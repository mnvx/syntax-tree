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
     * @var Tree
     */
    private $parent;

    /**
     * @param Node $node
     * @param Tree[] $children
     * @param Tree $parent
     */
    public function __construct(Node $node, array $children = [], Tree $parent = null)
    {
        $this->data = $node;
        $this->children = $children;
        $this->parent = $parent;
    }

    /**
     * Get current node
     * @return Node
     */
    public function getData()
    {
        return $this->data;
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
     * Add child item
     * 
     * @param Tree $child
     */
    public function addChild(Tree $child)
    {
        $this->children[] = $child;
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
     * Get tree as flat array. Indexes are word numbers.
     * 
     * @return Tree[]
     */
    public function toFlatArray($withParents = false)
    {
        $items[$this->data->getNumber()] = $this;

        foreach ($this->children as $item)
        {
            $items += $item->toFlatArray();
        }

        if ($withParents)
        {
            $items += $this->getFlatParents();
        }

        return $items;
    }

    protected function getFlatParents()
    {
        $parents = [];

        if ($this->data->getPartOfSpeech() !== Node::POS_VERB && $this->parent)
        {
            $parent[$this->parent->data->getNumber()] = $this->parent;
            $parents = $parent + $this->parent->getFlatParents();
        }

        return $parents;
    }

    /**
     * Serialisation to nested array
     * 
     * @return array
     */
    public function toArray()
    {
        $array = [
            'number' => $this->data->getNumber(),
            'text' => $this->data->getText(),
            'pos' => $this->data->getPartOfSpeech(),
            'children' => [],
        ];

        foreach ($this->children as $child)
        {
            $array['children'][] = $child->toArray();
        }

        return $array;
    }

    /**
     * Deserialisation from nested array
     * 
     * @param array $array
     * @return \static
     */
    public static function createFromArray(array $array, Tree $parent = null)
    {
        if (!isset($array['text']))
        {
            throw new SyntaxTreeException('"text" item not found');
        }
        if (!isset($array['number']))
        {
            throw new SyntaxTreeException('"number" item not found');
        }

        $current = new static(new Node($array['text'], $array['number'], $array['pos']), [], $parent);

        foreach ($array['children'] as $child)
        {
            $current->addChild(static::createFromArray($child, $current));
        }

        return $current;
    }

}
