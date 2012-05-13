<?php
namespace Grafizzi\Graph;

class Graph extends AbstractElement implements GraphInterface {

  public function build() {
    $type = $this->getType();
    $name = $this->getName();
    $ret = "$type $name {\n";
    $indent = str_repeat(' ', ($this->fDepth + 1) * self::DEPTH_INDENT);

    foreach ($this->fAttributes as $attribute) {
      $ret .= $indent . $attribute->build() . ";\n";
    }
    if (count($this->fAttributes)) {
      $ret .= "\n";
    }
    foreach ($this->fChildren as $child) {
      $ret .= $child->build() . "\n";
    }
    $ret .= "}\n";
    return $ret;
  }

  public static function getAllowedChildTypes() {
    $ret = array(
      'cluster',
      'edge',
      'node',
      'subgraph',
    );
    return $ret;
  }

  public function getDirected() {
    $ret = $this->directed;
    return $ret;
  }

  public static function getType() {
    $ret = 'graph';
    return $ret;
  }

  public function render() {
  }

  public function setDirected($directed) {
    $this->directed = $directed;
  }
}
