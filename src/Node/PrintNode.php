<?php

namespace Parser\Node;

class PrintNode extends Node {
    public function transpile()
    {
        $exprNode = NodeFactory::createNode($this->twigNode->getNode('expr'));
        return "{{ {$exprNode->transpile()} }}";
    }
}