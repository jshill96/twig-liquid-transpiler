<?php

namespace Parser\Node;

use Exception;
use Parser\Node\Expression\AddBinary;
use Parser\Node\Expression\ConstantExpression;
use Parser\Node\Expression\DivBinary;
use Parser\Node\Expression\FilterExpression;
use Parser\Node\Expression\ModBinary;
use Parser\Node\Expression\MulBinary;
use Parser\Node\Expression\NameExpression;
use Parser\Node\Expression\SubBinary;
use Parser\Node\Node;
use Parser\Node\TextNode;
use Twig\Node\Node as TwigNode;

class NodeFactory {

    public const nodes = [
        'Twig\Node\TextNode' => TextNode::class,
        'Twig\Node\BodyNode' => BodyNode::class,
        'Twig\Node\PrintNode' => PrintNode::class,
        'Twig\Node\Expression\FilterExpression' => FilterExpression::class,
        'Twig\Node\Expression\NameExpression' => NameExpression::class,
        'Twig\Node\Expression\Binary\AddBinary' => AddBinary::class,
        'Twig\Node\Expression\Binary\DivBinary' => DivBinary::class,
        'Twig\Node\Expression\Binary\SubBinary' => SubBinary::class,
        'Twig\Node\Expression\Binary\ModBinary' => ModBinary::class,
        'Twig\Node\Expression\Binary\MulBinary' => MulBinary::class,
        'Twig\Node\Expression\ConstantExpression' => ConstantExpression::class,
        'Twig\Node\Node' => Node::class,
    ];

    public static function createNode(TwigNode $twigNode): Node {

        if (!NodeFactory::supportsNode($twigNode)) {
            throw new Exception(get_class($twigNode) . " is not supported");
        }

        $nodeClass = NodeFactory::getNodeClassName($twigNode);
        return new $nodeClass($twigNode);
    }

    public static function supportsNode(TwigNode $node) {
        return \array_key_exists(get_class($node), NodeFactory::nodes);
    }

    public static function getNodeClassName(TwigNode $node): string {
        return NodeFactory::nodes[get_class($node)];
    }
}
