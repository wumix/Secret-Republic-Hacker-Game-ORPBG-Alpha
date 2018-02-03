<?php
use \Model\Skills;

class Controller_Skills extends Controller {
  public function __construct() { Hacker::check(Uri::base()); }


	public function action_index() {
    	$tVars = array();

    	$skills = Skills::process(Hacker::get('skills'));

    	if (Hacker::get('skill_points') && Input::post('add_points') && intval(Input::post('points')) <= Hacker::get('skill_points')) {
    		$skill_id = intval(Input::post('add_points'));
        $points = intval(Input::post('points'));

    		Skills::add_experience($skills[$skill_id], $points);
    		Skills::save(Hacker::id(), $skills);
    		Hacker::update(array('skill_points' => DB::expr('skill_points - ' . $points)));
    		Response::redirect(Uri::current());
    	}
    	$tVars['skills'] = $skills;
        return Response::forge(View::forge('skills/skills', $tVars))->set_header('Access-Control-Allow-Origin', '*');

    }
}
