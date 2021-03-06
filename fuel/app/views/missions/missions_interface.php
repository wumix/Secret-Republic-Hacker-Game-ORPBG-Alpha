<?php echo View::forge('global/header', array('hide_menu' => true)); ?>
<?php
	$mission = $task['data']['mission'];
?>
<style>
	.mission-interface .server {
		padding: 20px;
		background-color: #115b95;
		border-bottom: 2px solid rgba(0, 0, 0, 0.44);
		display: block;
		color: inherit;
	}
	.mission-interface .services {
		background-color: rgba(0, 0, 0, 0.44);

	}
	.mission-interface .services .service {
		border-left: 4px solid rgba(255, 255, 255, 0.14);
		padding: 10px;
		cursor:pointer;
		padding-left:20px;
	}

	.mission-interface .users {
		background-color: rgba(255, 255, 255, 0.14);
	}

	.mission-interface .user {
		padding: 5px;
		padding-left:20px;
		cursor:pointer;
	}
</style>
<div class="row mission-interface">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<?php  echo View::forge('components/modal', array('auto_open' => $new_objective, 'id' => 'objective', 'title' => $mission['objective']['name'], 'content' => '<div class="select">' . html_entity_decode(nl2br($mission['objective']['story']) . '</div>'))); ?>
		<div class="row">
			<div class="col-xs-6">
				<?php echo View::forge('components/countdown', array('start_value' => $task['task_start'], 'remaining' => $task['remaining'], 'duration' => $task['task_duration'], 'max_width' => '100px')); ?>
			</div>
			<div class="col-xs-6 text-center">
				<a class="btn" href="#objective" data-toggle="modal">objective</a><br/>
				<small><a href="#objective" data-toggle="modal"><?php echo $mission['objective']['name']; ?></a></small>
			</div>
		</div>
		<br/>

		<?php if (isset($mission['task'])): ?>
			<?php echo View::forge('missions/mission_inside_task', array('task' => $mission['task'], 'task_remaining' => $task_remaining)); ?>
		<?php else: ?>

			<?php if (isset($mission['connected'])): ?>
				<div class="server">
					<h4><?php echo $user['username']; ?> @ <?php echo $server['hostname']; ?> : <?php echo $service['port']; ?></h4>
					<small><?php echo isset($server['custom_name']) ? $server['custom_name'] : ($server['hide_hn'] ? 'unknown hostname' : $server['hostname']); ?></small>
				</div>
				<?php if ($service['welcome']): ?>
					<br/>
					<div class="well">
						<p><small>message from service</small></p>
						<?php echo $service['welcome']; ?>
					</div>
				<?php endif; ?>
					<?php if (isset($mission['connected']['entity'])): ?>
						<form method="post" class="text-center">
							<button type="submit" class="btn btn-default" name="action" value="exit">back 2 service</button>
						</form>
						<?php echo View::forge('missions/mission_entity_'. $service['type'], array('mission' => $mission, 'entity' => $entity)); ?>
					<?php else: ?>
						<form method="post" class="text-center">
							<button type="submit" class="btn btn-danger" name="service_action" value="disconnect">disconnect</button>
						</form>
						<?php if ($service['type'] == 3): ?>
							<?php if ($cql): ?>
								<?php echo View::forge('missions/query_output', array('cql' => $cql)); ?>
							<?php endif; ?>
							<form method="post">
								<div class="well">
								<div class="row">
									<div class="col-sm-10">
										<input type="text" name="query" class="form-control" required placeholder="Cardinal Query Languange" />
									</div>
									<div class="col-sm-2 text-center">
										<button type="submit" class="btn"><i class="fa fa-table" aria-hidden="true"></i></button>
									</div>
								</div>
							</div>
							</form>
						<?php elseif ($service['type'] == 2): ?>
							<h3 class="text-center">received</h3>
							<?php foreach($mission['entities'] as $entity_id => $entity): ?>
								<?php if ($entity['type'] != 1 || $entity['user_id'] != $user['user_id'] || $entity['user_id'] != $user['user_id'] || isset($entity['required_objective'])) continue; $found = true; ?>
								<?php echo View::forge('missions/missions_service_2', array('mission' => $mission, 'entity' => $entity)); ?>
							<?php endforeach;?>
							<?php if (!isset($found)): ?>
								<div class="alert alert-info text-center">
									Nothing here
								</div>
							<?php endif; ?>

							<h3 class="text-center">sent</h3>
							<?php foreach($mission['entities'] as $entity_id => $entity): ?>
								<?php if ($entity['type'] != 2 || $entity['user_id'] != $user['user_id'] || $entity['user_id'] != $user['user_id'] || isset($entity['required_objective'])) continue; $found2 = true; ?>
								<?php echo View::forge('missions/missions_service_2', array('mission' => $mission, 'entity' => $entity)); ?>
							<?php endforeach;?>
							<?php if (!isset($found2)): ?>
								<div class="alert alert-info text-center">
									Nothing here
								</div>
							<?php endif; ?>

						<?php else: ?>
							<?php foreach($mission['entities'] as $entity_id => $entity): ?>
								<?php if ($entity['user_id'] != $user['user_id'] || $entity['user_id'] != $user['user_id'] || isset($entity['required_objective'])) continue; $found = true; ?>
								<?php echo View::forge('missions/missions_service_3', array('mission' => $mission, 'entity' => $entity)); ?>
							<?php endforeach;?>
							<?php if (!isset($found)): ?>
								<div class="alert alert-info text-center">
									Nothing here
								</div>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				</div>
		  <?php else: ?>
				<?php foreach(array_filter($mission['servers'], function($s) { return $s['discovered']; }) as $server_id => $s): $found = true;
						$knownServices = 0;
						foreach($mission['services'] as $serv) if ($serv['discovered'] && $serv['quest_server_id'] == $server_id && !isset($service['required_objective'])) $knownServices++;
					?>
					<a class="server" onclick="$('#services_<?php echo $server_id; ?>').collapse('toggle');">
						<h4><?php echo $s['ip']; ?></h4>
						<small><?php echo isset($s['custom_name']) ? $s['custom_name'] : ($s['hide_hn'] ? 'unknown hostname' : $s['hostname']); ?> - <?php echo $knownServices; ?> known services</small>
					</a>
					<div class="services collapse" id="services_<?php echo $server_id; ?>">
						<div style="padding:20px;">
							<?php foreach($mission['services'] as $service_id => $service): if (!$service['discovered'] || $service['quest_server_id'] != $server_id || isset($service['required_objective'])) continue; ?>
								<?php $type = \Model\Missions::$service_types[$service['type']]; ?>
								<div class="service" onclick="$('#users_<?php echo $service_id; ?>').collapse('toggle');">
									<i class="fa fa-<?php echo $type['icon']; ?>"></i> <?php echo $type['name']; ?> | PORT <?php echo $service['port']; ?>
								</div>
								<div class="users collapse" id="users_<?php echo $service_id; ?>">
									<div style="padding: 15px;">
										<?php foreach($mission['users'] as $user_id => $user): if ($user['service_id'] != $service_id) continue; ?>
											<?php echo View::forge('components/modal', array('id' => 'user_' . $user_id, 'title' => $user['username'], 'content' => View::forge('missions/missions_service_user', array('user' => $user)))); ?>
											<div class="user" onclick="$('#user_<?php echo $user_id; ?>').modal('toggle')">
												<?php echo $user['username']; ?>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
						  <?php endforeach; ?>

							<?php echo View::forge('components/modal', array('id' => 'rename_' . $server_id, 'title' => 'Rename', 'content' => View::forge('missions/mission_server_rename', array('s' => $s, 'server_id' => $server_id)))); ?>

							<form method="post" class="text-center">
								<input type="hidden" name="server_action" value="<?php echo $server_id; ?>"/>
								<button type="submit" class="btn btn-default" name="action" value="scan">nmap</button>
								<a class="btn btn-default" data-toggle="modal" href="#rename_<?php echo $server_id; ?>">rename</a>
							</form>
						</div>
					</div>
				<?php endforeach; ?>
				<?php if (!isset($found)): ?>
					<div class="alert alert-info text-center">
						No server discovered
					</div>
				<?php endif; ?>
				<div class="text-center">
					<a data-toggle="modal" data-target="#ping" class="btn">ping</a>
				</div>
				<?php echo View::forge('components/modal', array('id' => 'ping', 'title' => 'ping server', 'content' =>
						'<form method="post" class="text-center">
							<input type="text" name="ip" placeholder="Target" class="form-control" />
							<button type="submit" class="btn btn-default " name="ping" value="true">ping</button>
						</form>')); ?>
			<?php endif;?>
		<?php endif; ?>
	</div>
</div>


	<br/><br/>
<br/><br/>
	<form method="post">
		<button class="btn btn-danger btn-block" type="submit" name="cancel" value="true">cancel mission</button>
	</form>

<?php if (Hacker::group() == 2): ?>
	<br/>
	<form method="post">
		<button class="btn btn-primary btn-block" type="submit" name="skip_objective" value="true">skip objective</button>
	</form>
	<button class="btn btn-default btn-block"  data-toggle="collapse" href="#debug" >debug</button>
<div class="well collapse" id="debug">
<pre>
<?php var_export($task); ?>
</pre>
</div>

<?php endif; ?>

<?php echo View::forge('global/footer'); ?>
