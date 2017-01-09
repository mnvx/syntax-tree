<?php

namespace SyntaxTreeApi\Model;

use SyntaxTree\Command\TensorFlowCommand;
use SyntaxTree\Command\MaltParserCommand;
use SyntaxTree\SyntaxTree;
use SyntaxTreeApi\Config\Configuration;

class ParseSyntaxCommandFactory
{

    const SYSTEM_TENSOR_FLOW = SyntaxTree::SYSTEM_TENSOR_FLOW;
    const SYSTEM_MALT_PARSER = SyntaxTree::SYSTEM_MALT_PARSER;

    public static function create($system = self::SYSTEM_TENSOR_FLOW)
    {
        switch ($system)
        {
            case self::SYSTEM_TENSOR_FLOW:
                return self::createTensorFlowCommand();
            case self::SYSTEM_MALT_PARSER:
                return self::createMaltParserCommand();
            default:
                throw new \RuntimeException(sprintf('Unknown system: %s', $system));
        }
    }

    public static function createTensorFlowCommand()
    {
        $command = new TensorFlowCommand();

        return $command
            ->setSyntaxnetPath(Configuration::getSyntaxNetPath())
            ->setModelPath(Configuration::getSyntaxNetModelPath());
    }

    public static function createMaltParserCommand()
    {
        $command = new MaltParserCommand();

        return $command
            ->setPath(Configuration::getMaltParserPath());
    }

}
