<?php
use \Model\Train;
use \Model\Task;
use \Model\Missions;
use \Model\DBMock;
use \Model\Rewards;

class Controller_Train extends Controller {
  public function __construct() { Hacker::check(Uri::base()); }

	public function action_index()
    {
    	if (Task::get_one(Hacker::id(), 2)) Response::redirect(Uri::create('train/train'));

    	$tVars = array();

    	$train = Train::process(Hacker::get('train'));

    	if (Input::post()) {
    		$data = array();
    		$data['train_type'] = intval(Input::post('train_type'));
        $train = $train[$data['train_type']];
        if (!$train['wait']) {
          $train_type = Train::types()[$data['train_type']];

          $mission = \DB::select()->from('quest')->where('quest_group_id', $train_type['quest_group_id'])->where('live', 1)->where('level', '<=', $train['level'])->order_by(DB::expr('RAND()'))->limit(1)->execute()->as_array();
          if (count($mission)) {
            $mission = $mission[0];
            $data['mission'] = Missions::prepare_data($mission['quest_id']);
    		    Task::create(Hacker::id(), 2, 1000, $data);
            Messages::voice('training_initiated');
            Response::redirect(Uri::create('train/train'));
          } else Messages::error("None of the supervisors are available for you. If this persists, please get in touch!");
        }
        Response::redirect(Uri::current());
    	}

    	$tVars['train'] = $train;
      return View::forge('train/train', $tVars);

    }

    public function action_train() {
    	$tVars = array();
    	$task = Task::get_one(Hacker::id(), 2);
    	if (!$task) Response::redirect(Uri::create('train'));

      if (isset($task['data']['mission']['completed'])) {

        $reward = array(
          'experience' => 10,
          'money' => 10,
          'skill_points' => 1,
          'train_id' => $task['data']['train_type'],
          'train_experience' => 10
        );
        Rewards::give(Hacker::id(), $reward, 'Train');

        $task['complete'] = time();
        $task['complete_status'] = 1;
        Task::save($task);

        $train = json_decode(Hacker::get('train'), true);
        $train[$task['data']['train_type']]['last'] = time();
        Hacker::update(array('train' => json_encode($train)));
        Response::redirect(Uri::create('train'));
      }
      return Missions::do_interface($task);
    }
}
