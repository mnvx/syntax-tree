<?php

namespace SyntaxTree;

class Tree
{

    /**
     * @var Node
     */
    private $data;

    /**
     * @var Tree[]
     */
    private $children;

    /**
     * @param Node $node
     * @param Tree[] $children
     */
    public function __construct(Node $node, array $children = [])
    {
        $this->data = $node;
        $this->children = $children;
    }

    /**
     * Get children items
     * 
     * @return Tree[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get tree in JSON format
     * 
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Serialisation to array
     * 
     * @return array
     */
    public function toArray()
    {
        $array = [
            'number' => $this->data->getNumber(),
            'text' => $this->data->getText(),
            'children' => [],
        ];

        foreach ($this->children as $child)
        {
            $array['children'][] = $child->toArray();
        }

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
        if (!isset($array['text']))
        {
            throw new SyntaxTreeException('"text" item not found');
        }
        if (!isset($array['number']))
        {
            throw new SyntaxTreeException('"number" item not found');
        }

        $children = [];
        foreach ($array['children'] as $child)
        {
            $children[] = static::createFromArray($child);
        }
        $node = new Node($array['text'], $array['number']);

        return new static($node, $children);
    }

}
