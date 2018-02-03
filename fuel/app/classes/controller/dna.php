<?php

class Controller_Dna extends Controller {
	public function __construct() { Hacker::check(Uri::base()); }

	public function action_index($reset_hash = false)  {
		$tVars = array();
		if (Input::post('voice')) {
			Hacker::update(array('voice_enabled' => !Hacker::get('voice_enabled')));
			Messages::voice('data_saved2');
			Response::redirect(Uri::current());
		}
		$skipCurrentPassword = false;
		if (Hacker::get('password_reset_hash') && Hacker::get('password_reset_hash') == $reset_hash) {
				$skipCurrentPassword = true;
		}

		if (Input::post('reset')) {
			if (!$skipCurrentPassword && !Hacker::compare_passwords(Input::post('password'), Hacker::get('password'))) {
				Messages::error("Your current password was incorrect. We've got our eyes on you!");
			} else {
				if (!Hacker::valid_password(Input::post('new_password'))) {
		      Messages::error("Password should be 5 - 30 characters long.");
		    } elseif (Input::post('new_password') != Input::post('new_password_confirm')) {
					Messages::error("The two did not match. Careful now!");
				} else {
					Hacker::update(array(
						'password' => Hacker::encrypt_password(Input::post('new_password')),
						'password_reset_hash' => NULL
					), Hacker::id());
					Messages::success('Password has been updated');
				}
			}

			Messages::voice('data_saved2');
			Response::redirect(Uri::current());
		}

		$tVars['skipCurrentPassword'] = $skipCurrentPassword;
		return View::forge('dna/dna', $tVars);
  }

}
