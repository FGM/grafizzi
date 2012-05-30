<?php

/**
 * @file
 * A recreation of Image_GraphViz test4.phpt
 *
 * @author Frédéric G. Marand <fgm@osinet.fr>
 *
 * Image_GraphViz version author: Philippe Jausions <jausions@php.net>
 *
 * Test 4: "HTML-like labels"
 *
 * Note: also tests ports.
 */

namespace Grafizzi\Graph\Tests;

use Monolog\Logger;

use Grafizzi\Graph\Attribute;
use Grafizzi\Graph\Edge;
use Grafizzi\Graph\Graph;
use Grafizzi\Graph\Node;
use Grafizzi\Graph\Subgraph;

require 'vendor/autoload.php';

/**
 * Graph test case.
 */
class IG04Test extends BaseGraphTest {

  public function setUp() {
    parent::setUp('G');
    $this->Graph->setDirected(true);
    $graph = &$this->Graph;
    $dic = $this->dic;
    $graph->setAttribute(new Attribute($dic, 'rankdir', 'LR'));

    $graph->addChild($nA = new Node($dic, 'a', array(
      new Attribute($dic, 'shape', 'plaintext'),
      new Attribute($dic, 'label', '<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
  <TR><TD ROWSPAN="3" BGCOLOR="yellow">class</TD></TR>
  <TR><TD PORT="here" BGCOLOR="lightblue">qualifier</TD></TR>
</TABLE>'),
     )));

    // Note: subgraph was created after some of its children in Image_GraphViz,
    // but Grafizzi lets you only add to existing elements, so it is created
    // earlier in this test.
    $graph->addChild($subgraph = new Subgraph($dic, 'subgraph', array(
      new Attribute($dic, 'title', ''),
      new Attribute($dic, 'rank', 'same'),
    )));
    $subgraph->addChild($nB = new Node($dic, 'b', array(
      new Attribute($dic, 'shape', 'ellipse'),
      new Attribute($dic, 'style', 'filled'),
      new Attribute($dic, 'label', '<TABLE BGCOLOR="bisque">
  <TR><TD COLSPAN="3">elephant</TD>
      <TD ROWSPAN="2" BGCOLOR="chartreuse"
          VALIGN="bottom" ALIGN="right">two</TD> </TR>
  <TR><TD COLSPAN="2" ROWSPAN="2">
        <TABLE BGCOLOR="grey">
          <TR> <TD>corn</TD> </TR>
          <TR> <TD BGCOLOR="yellow">c</TD> </TR>
          <TR> <TD>f</TD> </TR>
        </TABLE> </TD>
      <TD BGCOLOR="white">penguin</TD>
  </TR>
  <TR> <TD COLSPAN="2" BORDER="4" ALIGN="right" PORT="there">4</TD> </TR>
</TABLE>
  '),
    )));
    $subgraph->addChild($nC = new Node($dic, 'c', array(
      new Attribute($dic, 'shape', 'plaintext'),
      new Attribute($dic, 'label', 'long line 1<BR/>line 2<BR ALIGN="LEFT"/>line 3<BR ALIGN="RIGHT"/>'),
    )));

    $graph->addChild($edgeBC = new Edge($dic, $nC, $nB));

    $graph->addChild($nD = new Node($dic, 'd', array(
      new Attribute($dic, 'shape', 'triangle'),
    )));

    $graph->addChild($edgeDC = new Edge($dic, $nD, $nC, array(
      new Attribute($dic, 'label', '<TABLE>
  <TR><TD BGCOLOR="red" WIDTH="10"> </TD>
      <TD>Edge labels<BR/>also</TD>
      <TD BGCOLOR="blue" WIDTH="10"> </TD>
  </TR>
</TABLE>'),
    )));
    $graph->addChild($edgeAB = new Edge($dic, $nA, $nB, array(
      new Attribute($dic, 'arrowtail', 'diamond'),
    ), 'here', 'there'));
  }

  /**
   * Tests Graph->build()
   */
  public function testBuild() {
    $expected = <<<EOT
digraph G {
  rankdir=LR;

  a [ shape=plaintext, label=<<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
  <TR><TD ROWSPAN="3" BGCOLOR="yellow">class</TD></TR>
  <TR><TD PORT="here" BGCOLOR="lightblue">qualifier</TD></TR>
</TABLE>> ];
  subgraph "subgraph" {
    rank=same;

    b [ shape=ellipse, style=filled, label=<<TABLE BGCOLOR="bisque">
  <TR><TD COLSPAN="3">elephant</TD>
      <TD ROWSPAN="2" BGCOLOR="chartreuse"
          VALIGN="bottom" ALIGN="right">two</TD> </TR>
  <TR><TD COLSPAN="2" ROWSPAN="2">
        <TABLE BGCOLOR="grey">
          <TR> <TD>corn</TD> </TR>
          <TR> <TD BGCOLOR="yellow">c</TD> </TR>
          <TR> <TD>f</TD> </TR>
        </TABLE> </TD>
      <TD BGCOLOR="white">penguin</TD>
  </TR>
  <TR> <TD COLSPAN="2" BORDER="4" ALIGN="right" PORT="there">4</TD> </TR>
</TABLE>
  > ];
    c [ shape=plaintext, label=<long line 1<BR/>line 2<BR ALIGN="LEFT"/>line 3<BR ALIGN="RIGHT"/>> ];
  } /* /subgraph "subgraph" */
  c -> b;
  d [ shape=triangle ];
  d -> c [ label=<<TABLE>
  <TR><TD BGCOLOR="red" WIDTH="10"> </TD>
      <TD>Edge labels<BR/>also</TD>
      <TD BGCOLOR="blue" WIDTH="10"> </TD>
  </TR>
</TABLE>> ];
  a:here -> b:there [ arrowtail=diamond ];
} /* /digraph G */

EOT;
    $build = $this->Graph->build();
    $this->Graph->logger->debug("\n\n$build\n\n");
    $this->assertEquals($expected, $build, "Image_GraphViz test 4 passed.");
  }
}
