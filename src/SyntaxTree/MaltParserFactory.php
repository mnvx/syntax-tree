<?php

namespace SyntaxTree;

class MaltParserFactory extends ConllXParserFactory
{

    protected static $posMapping = [
        '%' => Node::POS_SYM,
        '-' => Node::POS_PUNCT,
        'A' => Node::POS_ADJ,
        'PR' => Node::POS_ADP,
        'SPRO' => Node::POS_PRON,
        'S' => Node::POS_NOUN,
        'SENT' => Node::POS_PUNCT,
        'V' => Node::POS_VERB,
    ];

    protected static function getPos(string $pos)
    {
        return static::$posMapping[$pos] ?? $pos;
    }

}