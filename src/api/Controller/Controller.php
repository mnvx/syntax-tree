<?php

namespace SyntaxTreeApi\Controller;

class Controller
{
    
    public function process($data)
    {
        $text = $data['text'] ?? null;

        $format = $data['format'] ?? null;
        $format = $format === '-' ? null : $format;

        $option = $data['option'] ?? null;


        $command = "syntaxnet/models/parsey_universal/parse.sh /home/tensor/tensorflow/Russian-SynTagRus";
        $path = '/home/tensor/tensorflow/models/syntaxnet/';

        $descriptors = [
            0 => ['pipe', 'r'], // stdin
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w'], // stderr
        ];

        // ! Sure what ~/.cache/bazel is acceseble for www-data !
        $process = proc_open($command, $descriptors, $pipes, $path);

        if (is_resource($process))
        {

            fwrite($pipes[0], $text);
            fclose($pipes[0]);

            $csv = stream_get_contents($pipes[1]);

            proc_close($process);
        }

        $syntaxTree = new \SyntaxTree\SyntaxTree();
        $tree = $syntaxTree->build($csv);

        switch ($format)
        {
            case 'CoNLL-X':
                echo $csv;
                break;

            case 'JSON':
                $options = $option === 'JSON_PRETTY_PRINT' ? JSON_PRETTY_PRINT : 0;
                echo $tree->toJson($options);
                break;

            default:
                require __DIR__ . DIRECTORY_SEPARATOR 
                    .  '..' . DIRECTORY_SEPARATOR
                    . 'view' . DIRECTORY_SEPARATOR
                    . 'index.php';
        }
    }
}
