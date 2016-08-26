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
     * @var Node[] Children nodes
     */
    protected $children;

    public function __construct($text, $number = null, array $children = [])
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

    /**
     * Serialisation to array
     * 
     * @return array
     */
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
    
    /**
     * Deserialisation from array
     * 
     * @param array $array
     * @return \static
     */
    public static function createFromArray(array $array)
    {
        $children = [];
        if (!empty($array['children']))
        {
            foreach ($array['children'] as $child)
            {
                $children[] = static::createFromArray($child);
            }
        }
        $node = new static($array['text'], $array['number'], $children);
        return $node;
    }

}
