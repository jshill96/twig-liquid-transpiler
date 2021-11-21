<?php

namespace Parser\Node\Expression;

use Parser\Node\Node;
use Parser\Node\NodeFactory;

class NameExpression extends Node {
    public function transpile()
    {
        return $this->twigNode->getAttribute('name');
    }
}