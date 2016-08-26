<?php

namespace SyntaxTreeApi\Controller;

use SyntaxTreeApi\Model\ParseSyntaxCommandFactory;
use SyntaxTree\SyntaxTree;

class Controller
{
    
    public function process($data)
    {
        $text = $data['text'] ?? null;

        $format = $data['format'] ?? null;
        $format = $format === '-' ? null : $format;

        $option = $data['option'] ?? null;

        $system = $data['system'] ?? null;

        $csv = '';
        if ($text)
        {
            $command = ParseSyntaxCommandFactory::create($system)
                ->setText($text);
            $csv = $command->execute();
        }

        $syntaxTree = new SyntaxTree();
        $trees = $syntaxTree->build($csv);

        switch ($format)
        {
            case 'CoNLL-X':
                echo $csv;
                break;

            case 'JSON':
                $options = $option === 'JSON_PRETTY_PRINT' ? JSON_PRETTY_PRINT : 0;
                echo $trees->toJson($options);
                break;

            default:
                require __DIR__ . DIRECTORY_SEPARATOR 
                    .  '..' . DIRECTORY_SEPARATOR
                    . 'view' . DIRECTORY_SEPARATOR
                    . 'index.php';
        }
    }
}
