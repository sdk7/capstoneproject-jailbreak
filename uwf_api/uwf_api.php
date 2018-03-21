<?php

	session_start();

	if(!isset($_SESSION['waypoints']) && empty($_SESSION['waypoints']))
		$_SESSION['waypoints'] = json_decode(file_get_contents('data.json'), true);

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
				if((int)$point['id'] === $id)
					return $point;
	}

	function get_all_waypoints() {
		return $_SESSION['waypoints'];
	}

	function get_by_coordinates($lat, $long){

	}

	if(isset($_REQUEST['call'])) {
		if(is_array($_REQUEST['call']))
			foreach($_REQUEST['call'] as $function)
				echo json_encode($function());
		else
			echo json_encode($_REQUEST['call']());
	}
