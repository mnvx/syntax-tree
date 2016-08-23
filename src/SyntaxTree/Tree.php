<?php

namespace SyntaxTree;

use RecursiveIterator;

class Tree implements RecursiveIterator
{

    /**
     * @var Node[] Nested array
     */
    private $data;

    private $position = 0;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function valid()
    {
        return isset($this->data[$this->position]);
    }

    public function hasChildren()
    {
        return is_array($this->data[$this->position]);
    }

    public function next()
    {
        $this->position++;
    }

    public function current()
    {
        return $this->data[$this->position];
    }

    public function getChildren()
    {
        if ($this->hasChildren())
        {
            return new static($this->data[$this->position]);
        }
        return null;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function key()
    {
        return $this->position;
    }

    public function toArray()
    {
        $array = [];
        foreach ($this->data as $item)
        {
            $array[] = $item->toArray();
        }

        return $array;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

}
