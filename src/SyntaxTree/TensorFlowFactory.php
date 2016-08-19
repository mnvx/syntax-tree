<?php

namespace SyntaxTree;

class TensorFlowFactory
{

    /**
     *
     * @param string $csv
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     * @return Tree
     */
    public static function create($csv, $delimiter = "\t", $enclosure = '"', $escape = "\\" )
    {
        $strings = explode("\n", $csv);
        $array = [];

        foreach ($strings as $string)
        {
            $array[] = str_getcsv($string, $delimiter, $enclosure, $escape);
        }
        $nodes = static::createNodes($array);

        return new Tree($nodes);
    }

    protected static function createNodes(&$array, $rootIndex = 0)
    {
        $data = [];
        foreach ($array as $item)
        {
            if ($item[6] == $rootIndex)
            {
                $children = static::createNodes($array, $item[0]);
                $data[] = new Node($item[1], $item[0], $children);
            }
        }
        return $data;
    }
}