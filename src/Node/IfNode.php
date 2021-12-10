<?php

namespace Parser\Node;

class IfNode extends Node
{
    public function transpile()
    {
        /** @var $tests \Twig\Node\Node */
        $tests = $this->twigNode->getNode('tests');

        $output = "";
        for ($i = 0; $i < \count($tests); $i += 2) {
            if ($i > 0) {
                $output .= '{% elsif ';
            } else {
                $output .= '{% if ';
            }

            $output .= NodeFactory::createNode($tests->getNode($i))->transpile() . " %}\n";

            $output .=  NodeFactory::createNode($tests->getNode($i + 1))->transpile();
        }

        if ($this->twigNode->hasNode('else')) {
            $output .= "} else {\n" . NodeFactory::createNode($this->twigNode->getNode('else'))->transpile();
        }

        return $output .= "{% endif %}\n";
    }
}
