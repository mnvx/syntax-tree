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
    public static function create($csv, $delimiter = "\t", $enclosure = "\t", $escape = "\\" )
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
            $row = str_getcsv($string, $delimiter, $enclosure, $escape);
            if (isset($row[3]))
            {
                $row[3] = static::getPos($row[3]);
            }
            $array[] = $row;
        }

        return static::createTrees($sentences);
    }

    protected static function getPos(string $pos)
    {
        return $pos;
    }
    
    protected static function createTrees(array $sentences)
    {
        $trees = [];
        foreach ($sentences as $array)
        {
            $treeArray = static::createNestedArray($array);

            // Here may be problem: https://github.com/tensorflow/models/issues/828
            if (count($treeArray) > 1)
            {
                if (in_array($treeArray[0]['pos'], [Node::POS_PUNCT || $treeArray[0]['pos'] === Node::POS_SYM]))
                {
                    unset($treeArray[0]);
                    $treeArray = array_values($treeArray);
                }
                else
                {
                    unset($treeArray[1]);
                }
            }
            elseif (count($treeArray) !== 1)
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
                    'pos' => $item[3],
                    'children' => $children,
                ];
            }
        }
        return $data;
    }
}
