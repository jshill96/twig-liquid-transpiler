<?php

namespace Parser\Node\Expression;

use Parser\Node\Node;

class ConstantExpression extends Node {
    public function transpile()
    {
        return $this->twigNode->getAttribute('value');
    }
}