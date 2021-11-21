<?php

namespace Parser\Node;

class TextNode extends Node {

    public function transpile(): string
    {
       return $this->twigNode->getAttribute('data');
    }
}