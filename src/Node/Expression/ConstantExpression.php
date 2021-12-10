<?php

namespace Parser\Node\Expression;

use Parser\Node\Node;

class ConstantExpression extends Node {
    public function transpile()
    {
        return var_export($this->twigNode->getAttribute('value'), true);
    }
}
