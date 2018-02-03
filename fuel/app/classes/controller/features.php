<?php
use \Model\Features;

class Controller_Features extends Controller {

  public function __construct() {
      $this->node = DB::select()->from('node')->where('node_id', Hacker::get('current_node'))->execute()->as_array();
      if (!$this->node) Response::redirect(Uri::base());
      $this->node = $this->node[0];
  }

  public function action_index() {
    $tVars = array();

    $node_features = Features::process($this->node['features']);
    $tVars['node_features'] = $node_features;
    $tVars['features'] = Features::features();
    return View::forge('features/features', $tVars);
  }

}
