<?php

namespace Parser\Node;

class IfNode extends Node
{
    public function transpile()
    {

        if ($this->requiresParens())
        {
            throw new \Exception('Liquid does not support parentheses in conditional statements: Line ' . $this->twigNode->getTemplateLine());
        }

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

    // See accepted answer here: https://stackoverflow.com/questions/14175177/how-to-walk-binary-abstract-syntax-tree-to-generate-infix-notation-with-minimall
    protected function requiresParens()
    {
        $conditionRoot = $this->twigNode->getNode('tests')->getNode(0);

        if (strpos(get_class($conditionRoot), 'ConstantExpression') !== false)
        {
            return false;
        }

        return $this->_requiresParens($conditionRoot->getNode('left'), get_class($conditionRoot), 'left') || $this->_requiresParens($conditionRoot->getNode('right'), get_class($conditionRoot), 'right');
    }

    private function _requiresParens($conditionTree, $parent, $direction): bool
    {
        if (strpos(get_class($conditionTree), 'ConstantExpression') !== false)
        {
            return false;
        }

        $operator = get_class($conditionTree);

        $canOmitParens = false;

        //If operator A is the child of operator B, and A has a higher precedence than B, the parentheses around A can be omitted.
        if ($this->getOperatorPredecedence($operator) > $this->getOperatorPredecedence($parent))
        {
            $canOmitParens = true;
        }

        //If a left-associative operator A is the left child of a left-associative operator B with the same precedence, the parentheses around A can be omitted. A left-associative operator is one for which x A y A z is parsed as (x A y) A z.
        // The twig compiler always uses parans, so assume there would be a pair
        if ($direction === 'left' && $this->getOperatorPredecedence($operator) === $this->getOperatorPredecedence($parent))
        {
            $canOmitParens = true;
        }

        //If a right-associative operator A is the right child of a right-associative operator B with the same precedence, the parentheses around A can be omitted. A right-associative operator is one for which x A y A z is parsed as x A (y A z).
        if ($direction === 'right' && $this->getOperatorPredecedence($operator) === $this->getOperatorPredecedence($parent))
        {
            $canOmitParens = true;
        }

        return !$canOmitParens;
    }

    private function getOperatorPredecedence($operatorClass): int
    {
        $namespaceParts = explode("\\", $operatorClass);
        $operator = $namespaceParts[\count($namespaceParts) - 1];

        // Full list of op precendence in twig: b-and, b-xor, b-or, or, and, ==, !=, <, >, >=, <=, in, matches, starts with, ends with, .., +, -, ~, *, /, //, %, is, **, |, and [ ]
        $operators = [
            'OrBinary',
            'AndBinary',
        ];

        return array_search($operator, $operators);
    }
}
