<?php

namespace SyntaxTree;

class Node
{

    /**
     * @var int Index number of phrase in sentence
     */
    protected $number;

    /**
     * @var string Phrase - text of syntax tree node
     */
    protected $text;

    /**
     * @param string $text
     * @param int $number
     */
    public function __construct($text, $number)
    {
        $this->text = $text;
        $this->number = $number;
    }

    /**
     * @return int
     */
    function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    function getText()
    {
        return $this->text;
    }

}
