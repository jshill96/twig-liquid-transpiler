<?php

namespace Parser\Node\Expression;

use Parser\Node\Node;
use Parser\Node\NodeFactory;

class AndBinary extends Node {
    public function transpile()
    {
        $operator = "and";
        $left = NodeFactory::createNode($this->twigNode->getNode('left'));
        $right = NodeFactory::createNode($this->twigNode->getNode('right'));

        return $left->transpile() . " {$operator} " .  $right->transpile();
    }
}
