<?php

class Controller_Grid extends Controller {
  public function __construct() { Hacker::check(Uri::base()); }

  public function action_nodes() {
    $tVars = array();
    $nodes = DB::select()->from('node')->where('owner_user_id', Hacker::id())->execute()->as_array();


    $tVars['nodes'] = $nodes;
    return View::forge('grid/grid_nodes', $tVars);
  }

  public function action_node() {
    $tVars = array();
    $node = DB::select()->from('node')->where('node_id', Hacker::get('current_node'))->execute()->as_array();
    if (!$node) Response::redirect(Uri::create('grid'));
    $node = $node[0];

    if (Input::post('rename')) {
      DB::update('node')->set(array('name' => Input::post('name')))->where('node_id', $node['node_id'])->execute();
      Response::redirect(Uri::current());
    }

    $tVars['node'] = $node;
    return View::forge('grid/grid_node', $tVars);
  }

  public function action_main($node_id) {
      $node = DB::select()->from('node')->where('owner_user_id', Hacker::id())->where('node_id', $node_id)->execute()->as_array();
      if (!$node) Response::redirect(Uri::create('grid/nodes'));
      Hacker::update(array('current_node' => $node_id));
      Response::redirect(Uri::create('grid/node'));
  }

	public function action_index() {
    $tVars = array();

    $currentZone = 1;
    $currentCluster = 1;

    $nodes = DB::select()->from('node')->where('zone', $currentZone)->where('cluster', $currentCluster)->execute();

    for ($i = 1; $i <= 10; $i++) {
      if (!isset($nodes[$i])) {
        $nodes[$i] = array(
          'owner_user_id' => null
        );
      }
    }

    $tVars['nodes'] = $nodes;
    return View::forge('grid/grid', $tVars);
  }
}
