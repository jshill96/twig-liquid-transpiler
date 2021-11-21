<?php

namespace Parser\Node;

use Twig\Node\Node as TwigNode;

class Node extends AbstractNode {

    public function __construct(TwigNode $twigNode) {
        $this->twigNode = $twigNode;
    }

    public function transpile()
    {
        $output = "";
        /**
         * @var \Twig\Node\Node $child
         */
        foreach($this->twigNode->getIterator() as $child) {
            $node = NodeFactory::createNode($child);
            $output .= $node->transpile();
        }

        return $output;
    }
}