<?php

namespace Parser\Node\Expression;

use Parser\Node\NodeFactory;

class PowerBinary extends \Parser\Node\Node
{
    public function transpile()
    {
        $left = NodeFactory::createNode($this->twigNode->getNode('left'));
        $right = NodeFactory::createNode($this->twigNode->getNode('right'));

        $num = eval('return ' . $left->transpile() . ';');
        $exp = eval('return ' . $right->transpile() . ';');
        return \pow($num, $exp);
    }
}
