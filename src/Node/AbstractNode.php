<?php

namespace Parser\Node;

use Twig\Node\Node as TwigNode;

abstract class AbstractNode {
    protected $twigNode;

    abstract public function transpile();
}