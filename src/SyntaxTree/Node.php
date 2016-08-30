<?php

namespace SyntaxTree;

class Node
{

    /**
     * Description for SynTagRus model: http://universaldependencies.org/ru/pos/index.html
     */
    const POS_ADJ = 'ADJ';      // adjective, прилагательное
    const POS_ADP = 'ADP';      // adposition, предлог (на, в, около, под, ...)
    const POS_ADV = 'ADV';      // adverb, наречие (более, как, так, ...)
    const POS_AUX = 'AUX';      // auxiliary verb, артикль, вспомогательный глагол (были, был, есть, ...)
    const POS_CONJ = 'CONJ';    // coordinating conjunction, соединительный союз (и, да(=и), ни, зато, ...)
    const POS_DET = 'DET';      // determiner, детерминатив (это, который, этого, ...)
    const POS_INTJ = 'INTJ';    // interjection, междометие (о, ох, а, ау, ...) - по факту не встречал
    const POS_NOUN = 'NOUN';    // noun, существительное
    const POS_NUM = 'NUM';      // numeral, числительное (1, 2, один, четверо, ...)
    const POS_PART = 'PART';    // particle, частица (не, ни, ...)
    const POS_PRON = 'PRON';    // pronoun, местоимение (я, ты, он, она, оно, кто, что...)
    const POS_PROPN = 'PROPN';  // proper noun, имя собственное (Мария, Сити, ЦК, ...) - по факту это всегда NOUN
    const POS_PUNCT = 'PUNCT';  // punctuation, пунктуация (.,"-)
    const POS_SCONJ = 'SCONJ';  // subordinating conjunction, подчинительный союз (как, чтобы, что, будто, ...)
    const POS_SYM = 'SYM';      // symbol, символ (%, ...)
    const POS_VERB = 'VERB';    // verb, глагол
    const POS_X = 'X';          // other, прочее (же, лишь, ...) - по факту ни разу не встречалось
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
