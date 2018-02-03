<?php
namespace Model;

class Emails extends \Model {
  private static $subjects = [
    'en' => [
      'welcome' => 'Welcome to our ranks, USERNAME',
      'reset' => 'Regain access to your account',
      'confirm' => 'Confirm your email and escalate your privileges'
    ]
  ];

  public static function send($target_email, $target_name, $template_id, $data, $language = 'en') {
    if (!filter_var($target_email, FILTER_VALIDATE_EMAIL)) return;
    \DB::insert('email_queue')->set([
      'target' => $target_email,
      'target_name' => $target_name,
      'template_id' => $template_id,
      'language' => $language,
      'data' => json_encode($data)
    ])->execute();

    return true;
  }

  public static function process_queued_email($queue) {
    $email = \Email::forge();
    $email->to($queue['target'], $queue['target_name']);
    $data = json_decode($queue['data'], true);
    $data = is_array($data) ? $data : [];

    $subject = Emails::$subjects[$queue['language']][$queue['template_id']];
    $email->subject(str_replace(array_keys($data), array_values($data), $subject));

    $email->html_body(\View::forge('emails/' . $queue['language'] . '/' . $queue['template_id'], $data));
    $email->send();
  }
}
