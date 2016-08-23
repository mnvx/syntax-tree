<?php

namespace SyntaxTreeApi\Model;

use SyntaxTree\Command\TensorFlowCommand;

class ParseSyntaxCommandFactory
{
    public static function createTensorFlowCommand()
    {
        $command = new TensorFlowCommand();

        return $command
            ->setSyntaxnetPath('/home/tensor/tensorflow/models/syntaxnet/')
            ->setModelPath('/home/tensor/tensorflow/Russian-SynTagRus');
    }
}
