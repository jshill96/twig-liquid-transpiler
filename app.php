<?php

require __DIR__ . '/vendor/autoload.php';

use Parser\Node\NodeFactory;
use \Twig\Loader\ArrayLoader;
use \Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/tests');
$twig = new Environment($loader);

// Load a test file
$testTemplatePath = __DIR__ . '/tests/basic.html.twig';
$fileInfo = pathinfo($testTemplatePath);
$fileContents = file_get_contents($testTemplatePath);

$stream = $twig->tokenize(new \Twig\Source($fileContents, $fileInfo['basename'], $testTemplatePath));

$nodes = $twig->parse($stream);

// echo $stream . "\n";
// var_dump($nodes->getNode('body'));

$printer = new Printer($nodes);

$printer->print();

class Printer {
  private $twigAST;

  public function __construct($ast) {
    $this->twigAST = $ast;
  }

  public function print() {
    echo $this->_print($this->twigAST->getNode('body'));

    echo "\n";
  }

  public function _print($node) {

    $node = NodeFactory::createNode($node);

    return $node->transpile();
  }

  public function handleNameExpression($node) {
    echo $node->getAttribute('name');

    foreach($node->getIterator() as $child) {
      $this->_print($child);
    }
  }

}