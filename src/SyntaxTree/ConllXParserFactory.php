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
                if ($array)
                {
                    $sentences[] = $array;
                }
                $array = [];
                continue;
            }
            $string = str_replace('"', '\\"', $string);
            $array[] = str_getcsv($string, $delimiter, $enclosure, $escape);
        }

        return static::createTrees($sentences);
    }
    
    protected static function createTrees(array $sentences)
    {
        $trees = [];
        foreach ($sentences as $array)
        {
            $treeArray = static::createNestedArray($array);
            if (count($treeArray) !== 1)
            {
                throw new SyntaxTreeException(sprintf(
                    'Root node must be one, but %d root nodes generated.', 
                    count($treeArray)
                ));
            }
            $trees[] = Tree::createFromArray($treeArray[0]);
        }

        return new TreeCollection($trees);
    }

    protected static function createNestedArray(array &$array, $rootIndex = 0)
    {
        $data = [];
        foreach ($array as $item)
        {
            if ($item[6] == $rootIndex)
            {
                $children = static::createNestedArray($array, $item[0]);
                $data[] = [
                    'number' => $item[0],
                    'text' => $item[1],
                    'children' => $children,
                ];
            }
        }
        return $data;
    }
}