<?php

namespace SyntaxTreeApi\Config;

class DefaultConfiguration implements ConfigurationInterface
{

    protected static $syntaxNetPath;
    protected static $syntaxNetModelPath;
    
    public static function getSyntaxNetPath()
    {
        return static::$syntaxNetPath;
    }

    public static function getSyntaxNetModelPath()
    {
        return static::$syntaxNetModelPath;
    }

}
