<?php

namespace Parser\Node\Expression;

use Parser\Node\Node;
use Parser\Node\NodeFactory;

class FilterExpression extends Node {
    public function transpile()
    {
        $node = NodeFactory::createNode($this->twigNode->getNode('node'));
        return $node->transpile();
    }
}