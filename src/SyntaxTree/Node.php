<?php

namespace SyntaxTree;

class Node
{

    const POS_VERB = 'VERB';
    const POS_NOUN = 'NOUN';
    const POS_CONJ = 'CONJ';
    const POS_PART = 'PART';
    const POS_ADP = 'ADP';
    const POS_ADJ = 'ADJ';
    const POS_SCONJ = 'SCONJ';
    const POS_PRON = 'PRON';
    const POS_DET = 'DET';
    const POS_NUM = 'NUM';
    const POS_AUX = 'AUX';
    const POS_PUNCT = 'PUNCT';
    const POS_UNKNOWN = '_';

    /**
     * @var int Index number of phrase in sentence
     */
    protected $number;

    /**
     * @var string Phrase - text of syntax tree node
     */
    protected $text;

    /**
     * @var string PartOfSpeech
     */
    protected $partOfSpeech;

    /**
     * @param string $text
     * @param int $number
     * @param string $partOfSpeech
     */
    public function __construct($text, $number, $partOfSpeech = '_')
    {
        $this->text = $text;
        $this->number = $number;
        $this->partOfSpeech = $partOfSpeech;
    }

    /**
     * @return int
     */
    function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    function getPartOfSpeech()
    {
        return $this->partOfSpeech;
    }

}
