<?php

namespace Parser\Node\Expression;

use Parser\Node\NodeFactory;

class LessEqualBinary extends \Parser\Node\Node
{
    public function transpile()
    {
        $operator = "<=";
        $left = NodeFactory::createNode($this->twigNode->getNode('left'));
        $right = NodeFactory::createNode($this->twigNode->getNode('right'));

        return $left->transpile() . " {$operator} " .  $right->transpile();
    }
}
