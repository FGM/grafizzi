<?php

/**
 * @file
 * A recreation of Image_GraphViz test16.phpt
 *
 * @author Frédéric G. Marand <fgm@osinet.fr>
 *
 * Image_GraphViz version author: Philippe Jausions <jausions@php.net>
 *
 * Test 16: "Drawing of hash table"
 *
 * "Graph definition taken from GraphViz documentation"
 */

namespace Grafizzi\Graph\Tests;

use Grafizzi\Graph\Attribute;
use Grafizzi\Graph\Edge;
use Grafizzi\Graph\Graph;
use Grafizzi\Graph\Node;

require 'vendor/autoload.php';

/**
 * Graph test case.
 */
class IG16Test extends BaseGraphTest {

  public function setUp() {
    // not strict by default.
    parent::setUp();
    $g = $this->Graph;
    $dic = $this->dic;
    $g->setDirected(true);
    $g->setAttributes(array(
      new Attribute($dic, 'nodesep', 0.05),
      new Attribute($dic, 'rankdir', 'LR'),
    ));

    $recordShape = new Attribute($dic, 'shape', 'record');

    $g->addChild($node0 = new Node($dic, 'node0', array(
      $recordShape,
      new Attribute($dic, 'label', '<f0> |<f1> |<f2> |<f3> |<f4> |<f5> |<f6> | '),
      new Attribute($dic, 'height', 2.5),
    )));
    $g->addChild($node1 = new Node($dic, 'node1', array(
      $recordShape,
      new Attribute($dic, 'label', '{<n> n14 | 719 |<p> }'),
    )));
    $g->addChild($node2 = new Node($dic, 'node2', array(
      $recordShape,
      new Attribute($dic, 'label', '{<n> a1 | 805 |<p> }'),
    )));
    $g->addChild($node3 = new Node($dic, 'node3', array(
      $recordShape,
      new Attribute($dic, 'label', '{<n> i9 | 718 |<p> }'),
    )));
    $g->addChild($node4 = new Node($dic, 'node4', array(
      $recordShape,
      new Attribute($dic, 'label', '{<n> e5 | 989 |<p> }'),
    )));
    $g->addChild($node5 = new Node($dic, 'node5', array(
      $recordShape,
      new Attribute($dic, 'label', '{<n> t20 | 959 |<p> }'),
    )));
    $g->addChild($node6 = new Node($dic, 'node6', array(
      $recordShape,
      new Attribute($dic, 'label', '{<n> o15 | 794 |<p> }'),
    )));
    $g->addChild($node7 = new Node($dic, 'node7', array(
      $recordShape,
      new Attribute($dic, 'label', '{<n> s19 | 659 |<p> }'),
    )));

  $nullTitle = array(
    new Attribute($dic, 'title', null),
  );
  $g->addChild(new Edge($dic, $node0, $node1, $nullTitle, 'f0', 'n'));
  $g->addChild(new Edge($dic, $node0, $node2, $nullTitle, 'f1', 'n'));
  $g->addChild(new Edge($dic, $node0, $node3, $nullTitle, 'f2', 'n'));
  $g->addChild(new Edge($dic, $node0, $node4, $nullTitle, 'f5', 'n'));
  $g->addChild(new Edge($dic, $node0, $node5, $nullTitle, 'f6', 'n'));
  $g->addChild(new Edge($dic, $node2, $node6, $nullTitle, 'p', 'n'));
  $g->addChild(new Edge($dic, $node4, $node7, $nullTitle, 'p', 'n'));
  }

  /**
   * Tests Graph->build()
   */
  public function testBuild() {
    $expected = <<<'EOT'
digraph G {
  nodesep=0.05;
  rankdir=LR;

  node0 [ shape=record, label="<f0> |<f1> |<f2> |<f3> |<f4> |<f5> |<f6> | ", height=2.5 ];
  node1 [ shape=record, label="{<n> n14 | 719 |<p> }" ];
  node2 [ shape=record, label="{<n> a1 | 805 |<p> }" ];
  node3 [ shape=record, label="{<n> i9 | 718 |<p> }" ];
  node4 [ shape=record, label="{<n> e5 | 989 |<p> }" ];
  node5 [ shape=record, label="{<n> t20 | 959 |<p> }" ];
  node6 [ shape=record, label="{<n> o15 | 794 |<p> }" ];
  node7 [ shape=record, label="{<n> s19 | 659 |<p> }" ];
  node0:f0 -> node1:n;
  node0:f1 -> node2:n;
  node0:f2 -> node3:n;
  node0:f5 -> node4:n;
  node0:f6 -> node5:n;
  node2:p -> node6:n;
  node4:p -> node7:n;
} /* /digraph G */

EOT;
    $build = $this->Graph->build();
    $this->Graph->logger->debug("\n\n$build\n\n");
    $this->assertEquals($expected, $build, "Image_GraphViz test 16 passed.");
  }
}
