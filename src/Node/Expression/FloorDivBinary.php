<?php

namespace Parser\Node\Expression;

use Parser\Node\NodeFactory;

class FloorDivBinary extends \Parser\Node\Node
{
    public function transpile()
    {
        $left = NodeFactory::createNode($this->twigNode->getNode('left'));
        $right = NodeFactory::createNode($this->twigNode->getNode('right'));

        $left = eval('return ' . $left->transpile() . ';');
        $right = eval('return ' . $right->transpile() . ';');
        return \floor($left / $right);
    }
}
