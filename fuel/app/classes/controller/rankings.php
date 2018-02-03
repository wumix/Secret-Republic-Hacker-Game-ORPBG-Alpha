<?php

class Controller_Rankings extends Controller {
	public function action_index() {
    	$tVars = array();

			$result = DB::select(DB::expr('COUNT(*) as count'))->from('user')->where('ranking', '!=', 0)->execute();

    	$config = array(
			    'pagination_url' => Uri::create('rankings'),
			    'total_items'    => $result->current()['count'],
			    'per_page'       => 20,
			    'uri_segment'    => 'page',
			);
    	$pagination = Pagination::forge('mypagination', $config);

    	$rankings = DB::select('user_id', 'username', 'ranking', 'ranking_points', 'knowledge_points')->from('user')->where('ranking', '!=', 0)
							->order_by('ranking', 'asc')
    						->limit($pagination->per_page)->offset($pagination->offset)->execute()->as_array();

    	$tVars['rankings'] = $rankings;
			return View::forge('rankings/rankings', $tVars)->set_safe('pagination', $pagination);
    }

    public function action_groups() {
    	$tVars = array();

		$result = DB::select(DB::expr('COUNT(*) as count'))->from('hacker_group')->where('ranking', '!=', 0)->execute();

    	$config = array(
		    'pagination_url' => Uri::create('rankings'),
		    'total_items'    => $result->current()['count'],
		    'per_page'       => 20,
		    'uri_segment'    => 'page',
		);
    	$pagination = Pagination::forge('mypagination', $config);

    	$rankings = DB::select('hacker_group_id', 'name', 'ranking', 'ranking_points')->from('hacker_group')->where('ranking', '!=', 0)
    						->limit($pagination->per_page)->offset($pagination->offset)->execute()->as_array();

    	$tVars['rankings'] = $rankings;
    	$tVars['pagination'] = $pagination;
			return View::forge('rankings/rankings_groups', $tVars);
    }
}
