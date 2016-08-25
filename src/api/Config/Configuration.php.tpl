<?php

namespace SyntaxTreeApi\Config;

class Configuration extends DefaultConfiguration
{

    /**
     * Path to TensorFlow`s syntaxnet
     * @var string
     */
    protected static $syntaxNetPath = '/home/tensor/tensorflow/models/syntaxnet/';

    /**
     * Path to model for syntaxnet
     * @var string
     */
    protected static $syntaxNetModelPath = '/home/tensor/tensorflow/Russian-SynTagRus';

    /**
     * Path to MaltParser (directory with russian-malt.sh)
     * @var string
     */
    protected static $maltParserPath = '/home/tensor/malt/installation';

}
