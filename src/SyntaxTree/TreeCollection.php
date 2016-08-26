<?php

namespace SyntaxTree;

use ArrayAccess;
use Iterator;

class TreeCollection implements Iterator, ArrayAccess
{

    /**
     * @var Tree[]
     */
    protected $trees;
    protected $position = 0;

    public function __construct(array $trees)
    {
        $this->trees = $trees;
    }

    function rewind()
    {
        $this->position = 0;
    }

    function current()
    {
        return $this->trees[$this->position];
    }

    function key()
    {
        return $this->position;
    }

    function next()
    {
        ++$this->position;
    }

    function valid()
    {
        return isset($this->trees[$this->position]);
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset))
        {
            $this->trees[] = $value;
        }
        else
        {
            $this->trees[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->trees[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->trees[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->trees[$offset]) ? $this->trees[$offset] : null;
    }

    public function toArray()
    {
        $array = [];

        foreach ($this->trees as $tree)
        {
            $array[] = $tree->toArray();
        }

        return $array;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public static function createFromJson($jsonString)
    {
        $array = json_decode($jsonString, true);

        $data = [];
        foreach ($array as $item)
        {
            $data[] = Tree::createFromArray($item);
        }

        return new static($data);
    }

}
