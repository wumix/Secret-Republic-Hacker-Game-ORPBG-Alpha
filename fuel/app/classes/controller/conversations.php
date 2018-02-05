<?php
use \Model\Conversation;

class Controller_Conversations extends Controller {
	public function __construct() { Hacker::check(Uri::base()); }
	public function action_conversation($conv) {
		$conv = DB::select('conversation_id', 'title', 'user_1_id', 'user_2_id', 'unseen', 'last_replier_id')->from('conversation')->where('conversation_id', $conv)->where('parent_conversation_id', 'IS', NULL)->where(function($q) {
				return $q->where('user_1_id', Hacker::id())->or_where('user_2_id', Hacker::id());
			})->execute()->as_array();
		$conv = $conv[0];

		if ($conv['unseen'] && $conv['last_replier_id'] != Hacker::id()) {
			DB::update('conversation')->set(array('unseen' => NULL))->where('conversation_id', $conv['conversation_id'])->execute();
		}

		if (Input::post()) {
			$reply = array(
				'user_1_id' => Hacker::id(),
				'parent_conversation_id' => $conv['conversation_id'],
				'message' => Input::post('message')
				);
			DB::insert('conversation')->set($reply)->execute();

			$conv['last_replier_id'] = Hacker::id();
			$conv['unseen'] = 1;
			$conv['last_reply_timestamp'] = time();
			DB::update('conversation')->set($conv)->where('conversation_id', $conv['conversation_id'])->execute();
		}
		$replies = DB::select()->from('conversation')->where('parent_conversation_id', $conv['conversation_id'])->or_where('conversation_id', $conv['conversation_id'])->order_by('created_at', 'desc')->execute()->as_array();

		foreach ($replies as &$r) {
			$r['message'] = \Model\BBCode::parse($r['message']);
		}

		$tVars = array();
		$tVars['replies'] = $replies;
		$tVars['conv'] = $conv;
				return View::forge('conversations/conversation', $tVars);
	}

	public function action_new($to = false) {
		$tVars = array();

		if (Input::post() && Input::post('username') != Hacker::username()) {
			$user_2_id = DB::select('user_id')->from('user')->where('username', Input::post('username'))->execute()->as_array();
			if (!$user_2_id) {
				Messages::error('Target not found!');
			} else {
				$c_id = Conversation::create(Input::post('title'), Hacker::id(), $user_2_id[0]['user_id'], Input::post('message'));
				Response::redirect(Uri::create('conversations/conversation/' . $c_id));
			}
		}
		return View::forge('conversations/conversation_new', $tVars);
	}

	public function action_index()
    {
    	$tVars = array();

    	$convs = DB::select()->from('conversation')->where('parent_conversation_id', 'IS', NULL)->where(function($q) {
    		return $q->where('user_1_id', Hacker::id())->or_where('user_2_id', Hacker::id());
    	})->order_by('last_reply_timestamp', 'desc')->execute()->as_array();

    	$other_participants = array();
    	foreach ($convs as &$c) {
    		$c['op'] = $c['user_1_id'] == Hacker::id() ? $c['user_2_id'] : $c['user_1_id'];
    		$other_participants[] = $c['op'];
    	}

    	$op_usernames = array();
    	if (count($other_participants)) {
	    	$other_participants = DB::select('username', 'user_id')->from('user')->where('user_id', 'IN', $other_participants)->execute()->as_array();

	    	foreach($other_participants as $op) {
	    		$op_usernames[$op['user_id']] = $op['username'];
	    	}
		}
		$op_usernames[-1] = 'System';
    	$tVars['op_usernames'] = $op_usernames;
    	$tVars['convs'] = $convs;
				return View::forge('conversations/conversations', $tVars);

    }
}
