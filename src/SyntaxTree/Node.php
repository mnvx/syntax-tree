<?php

namespace SyntaxTree;

class Node
{

    protected $number;

    protected $text;

    /**
     * @var Node[]
     */
    protected $children;

    public function __construct($text, $number = null, $children = [])
    {
        $this->text = $text;
        $this->number = $number;
        $this->children = $children;
    }

    function getNumber()
    {
        return $this->number;
    }

    function getText()
    {
        return $this->text;
    }

    function getChildren()
    {
        return $this->children;
    }

    public function toArray()
    {
        $children = [];
        foreach ($this->children as $item)
        {
            $children[] = $item->toArray();
        }

        $array = [
            'number' => $this->getNumber(),
            'text' => $this->getText(),
            'children' => $children,
        ];

        return $array;
    }

}
