<?php

namespace SyntaxTree\Command;

abstract class AbstractParseSyntaxCommand implements CommandInterface
{

    protected $text;
    
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }
}
