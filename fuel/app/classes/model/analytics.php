<?php

namespace Model;

class Analytics extends \Model {
  public static function record($event, $data, $user_id = null) {
    try {
      \DB::insert('analytics')->set(array('event' => $event, 'data' => json_encode($data), 'user_id' => \Hacker::id(), 'server_data' => json_encode($_SERVER)))->execute();
    } catch (\Exception $ex) {}
  }
}
