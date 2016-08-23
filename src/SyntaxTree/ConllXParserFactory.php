<?php

namespace SyntaxTree;

class ConllXParserFactory
{

    /**
     *
     * @param string $csv
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     * @return TreeCollection
     */
    public static function create($csv, $delimiter = "\t", $enclosure = '"', $escape = "\\" )
    {
        $strings = explode("\n", $csv);
        $sentences = [];
        $array = [];

        foreach ($strings as $string)
        {
            if (!$string)
            {
                $sentences[] = $array;
                $array = [];
                continue;
            }
            $string = str_replace('"', '\\"', $string);
            $array[] = str_getcsv($string, $delimiter, $enclosure, $escape);
        }
        if ($array)
        {
            $sentences[] = $array;
        }

        return static::createTrees($sentences);
    }
    
    protected static function createTrees(array $sentences)
    {
        $trees = [];
        foreach ($sentences as $array)
        {
            $trees[] = new Tree(static::createNodes($array));
        }

        return new TreeCollection($trees);
    }

    protected static function createNodes(array &$array, $rootIndex = 0)
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