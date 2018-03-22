<?php

	// Resumes previous session or creates a new one if it doesn't exist.
	// That means that we only decode the data.json once and it's saved in memory
	session_start();

	if(!isset($_SESSION['waypoints']) && empty($_SESSION['waypoints']))
		$_SESSION['waypoints'] = json_decode(file_get_contents('data.json'), true);

	if(!isset($_SESSION['users']) && empty($_SESSION['users']))
		$_SESSION['users'] = json_decode(file_get_contents('users.json'), true);

	function get_by_number($num = NULL){
		$returnpoints = array();
		$num = strtoupper($num) ?: (strtoupper($_REQUEST['num']) ?: NULL);

		if($num === NULL)
			return false;

		if(is_array($_SESSION['waypoints']))
			foreach($_SESSION['waypoints'] as $point)
				if(preg_match("/{$num}/", strtoupper($point['building_num'])))
					array_push($returnpoints,$point);

		return !empty($returnpoints) ? $returnpoints : false;
	}

	function get_by_name($name = NULL) {
		$returnpoints = array();
		$name = strtoupper($name) ?: (strtoupper($_REQUEST['name']) ?: NULL);
		if($name === NULL)
			return false;

		if(is_array($_SESSION['waypoints']))
			foreach($_SESSION['waypoints'] as $point)
				if(
					preg_match("/{$name}/",strtoupper($point['alias']))
					|| preg_match("/{$name}/",strtoupper($point['name']))
				)
					array_push($returnpoints,$point);

		return !empty($returnpoints) ? $returnpoints : false;
	}

	function get_by_id($id = NULL) {
		$id = is_numeric($id) ? $id : (is_numeric($_REQUEST['id']) ? $_REQUEST['id'] : NULL);
		if($id === NULL)
			return false;

		if(is_array($_SESSION['waypoints']))
			foreach($_SESSION['waypoints'] as $point)
				if((int)$point['id'] === (int)$id)
					return $point;
	}

	function get_all_waypoints() {
		return $_SESSION['waypoints'];
	}

	function get_by_coordinates($lat, $long){

	}

	function refresh_waypoints() {
		$_SESSION['waypoints'] = json_decode(file_get_contents('data.json'), true);
		if(isset($_SESSION['waypoints']) && !empty($_SESSION['waypoints']))
			return ['success' => 'success'];
		else
			return ['error' => 'Failed to refresh waypoints'];
	}

	function refresh_users() {
		$_SESSION['users'] = json_decode(file_get_contents('users.json'), true);
		if(isset($_SESSION['users']) && !empty($_SESSION['users']))
			return ['success' => 'success'];
		else
			return ['error' => 'Failed to refresh users'];
	}

	function verify_user() {
		$access = false;

		if(isset($_REQUEST['key'])) {
			$key = $_REQUEST['key'];
			if(isset($_SESSION['users']) && is_array($_SESSION['users']))
				foreach($_SESSION['users'] as $user)
					if($user['key'] === (string)$key)
						$access = true;
		}

		return $access;
	}

	if(isset($_REQUEST['call'])) {
		if(verify_user()) {
			if(is_array($_REQUEST['call'])) {
				foreach($_REQUEST['call'] as $function) {
					if(array_search($function,get_defined_functions()['user']) !== false) {
						echo json_encode($function());
					}
					else {
						echo json_encode(['error' => 'invalid function']);
					}
				}
			}
			else {
				if(array_search($_REQUEST['call'],get_defined_functions()['user']) !== false) {
					echo json_encode($_REQUEST['call']());
				}
				else {
					echo json_encode(['error' => 'invalid function']);
				}
			}

		}
		else {
			echo json_encode(['error'=>'invalid key']);
		}
	}
