<?php
use \Model\Rewards;

class Controller_Rewards extends Controller {
  public function __construct() { Hacker::check(Uri::base()); }

	public function action_index() {
    	$tVars = array();

      $result = DB::select(DB::expr('COUNT(*) as count'))->from('reward')->where('user_id', Hacker::id())->execute();

        $config = array(
          'pagination_url' => Uri::create('rankings'),
          'total_items'    => $result->current()['count'],
          'per_page'       => 20,
          //'uri_segment'    => 3,
          'uri_segment'    => 'page',
      );
        $pagination = Pagination::forge('mypagination', $config);

        $rewards = DB::select()->from('reward')->where('user_id', Hacker::id())->order_by('created_at', 'desc')
          ->limit($pagination->per_page)->offset($pagination->offset)->execute()->as_array();

          $tVars['rewards'] = $rewards;
        return View::forge('rewards/rewards', $tVars)->set_safe('pagination', $pagination);

    }

    public function action_reward($reward) {
    	$tVars = array();

    	$reward = DB::select()->from('reward')->where('user_id', Hacker::id())->where('reward_id', $reward)->limit(1)->execute()->as_array();
      if (!count($reward)) Response::redirect(Uri::base());
    	$reward = $reward[0];

    	if (Input::post('claim')) {
    		Rewards::claim($reward);
        Messages::success('Reward has been applied to your account, ' . Hacker::username() . '!');
    		Response::redirect(Uri::current());
    	}
      if (isset($reward['achievements'])) $reward['achievements'] = json_decode($reward['achievements'], true);
    	   $tVars['reward'] = $reward;
         return View::forge('rewards/reward', $tVars);
    }
}
