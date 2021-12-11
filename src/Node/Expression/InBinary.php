<?php

namespace Parser\Node\Expression;

use Parser\Node\NodeFactory;

class InBinary extends \Parser\Node\Node
{
    public function transpile()
    {
        $operator = "contains";
        $left = NodeFactory::createNode($this->twigNode->getNode('left'));
        $right = NodeFactory::createNode($this->twigNode->getNode('right'));

        if (!($left instanceof ConstantExpression) || !($right instanceof ConstantExpression))
        {
            throw new \Exception('Liquid does not allow non-string operands for the contains operator: Line ' . $this->twigNode->getTemplateLine() . ' in ' . $this->twigNode->getTemplateName());
        }

        // Twig's 'in' operator gets turned into Liquid's 'contains' operator
        // The arguments are swapped
        return $right->transpile(). " {$operator} " . $left->transpile();
    }
}
