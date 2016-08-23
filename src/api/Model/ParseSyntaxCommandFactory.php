<?php

namespace SyntaxTreeApi\Model;

use SyntaxTree\Command\TensorFlowCommand;
use SyntaxTreeApi\Config\Configuration;

class ParseSyntaxCommandFactory
{
    public static function createTensorFlowCommand()
    {
        $command = new TensorFlowCommand();

        return $command
            ->setSyntaxnetPath(Configuration::getSyntaxNetPath())
            ->setModelPath(Configuration::getSyntaxNetModelPath());
    }
}
