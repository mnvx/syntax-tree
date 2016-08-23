<?php

namespace SyntaxTree\Command;

class TensorFlowCommand extends AbstractParseSyntaxCommand implements CommandInterface
{

    protected $syntaxnetPath;

    protected $modelPath;

    public function setSyntaxnetPath($syntaxnetPath) {
        $this->syntaxnetPath = $syntaxnetPath;
        return $this;
    }

    public function setModelPath($modelPath) {
        $this->modelPath = $modelPath;
        return $this;
    }

    public function execute()
    {
        $command = "syntaxnet/models/parsey_universal/parse.sh " . $this->modelPath;

        $descriptors = [
            0 => ['pipe', 'r'], // stdin
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w'], // stderr
        ];

        // ! Sure what ~/.cache/bazel is acceseble for www-data !
        $process = proc_open($command, $descriptors, $pipes, $this->syntaxnetPath);

        if (is_resource($process))
        {

            fwrite($pipes[0], $this->text);
            fclose($pipes[0]);

            $csv = stream_get_contents($pipes[1]);

            proc_close($process);
        }

        return $csv;
    }
}
