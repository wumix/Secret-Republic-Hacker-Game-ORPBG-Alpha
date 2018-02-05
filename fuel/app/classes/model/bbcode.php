<?php
namespace Model;
class BBCode extends \Model {
  public static function parse($text) {
    $parser = new \JBBCode\Parser();
    $parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
    $parser->parse($text);
    return $parser->getAsHtml();
  }
}
