<?php

namespace SyntaxTree;

class SyntaxTree
{
    const SYSTEM_TENSOR_FLOW = 1;
    const SYSTEM_MALT_PARSER = 2;

    protected $system = self::SYSTEM_TENSOR_FLOW;

    protected $delimiter = "\t";
    protected $enclosure = '"';
    protected $escape = "\\";

    public function __construct()
    {
    }

    public function getSystem()
    {
        return $this->system;
    }

    public function setSystem($system)
    {
        $this->system = $system;
        return $this;
    }

    public function getDelimiter()
    {
        return $this->delimiter;
    }

    public function getEnclosure()
    {
        return $this->enclosure;
    }

    public function getEscape()
    {
        return $this->escape;
    }

    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    public function setEnclosure($enclosure)
    {
        $this->enclosure = $enclosure;
        return $this;
    }

    public function setEscape($escape)
    {
        $this->escape = $escape;
        return $this;
    }

    public function build($source)
    {
        switch ($this->system)
        {
            case (self::SYSTEM_TENSOR_FLOW):
                return TensorFlowFactory::create(
                    $source,
                    $this->delimiter,
                    $this->enclosure,
                    $this->escape
                );

            case (self::SYSTEM_MALT_PARSER):
                return MaltParserFactory::create(
                    $source,
                    $this->delimiter,
                    $this->enclosure,
                    $this->escape
                );
        }
    }

}
