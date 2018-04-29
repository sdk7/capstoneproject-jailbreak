<?php
	function getlocations() {
		// Where we would call API
		if(!isset($_SESSION['waypoints']) || $_SESSION['waypoints'] === NULL) {
			$api_version = 'v1.0.0';
			$api_key     = 'apikeygoeshere';
			$get_waypoints_url  = "http://ec2-18-219-246-128.us-east-2.compute.amazonaws.com/index.php/{$api_version}/{$api_key}/GET/buildings";

			$_SESSION['waypoints'] = json_decode(file_get_contents($get_waypoints_url),true);
		}
		$start_options = array();
		$end_options   = array();
		if(!isset($_SESSION['waypoints']['error']))	{
			foreach($_SESSION['waypoints'] as $point) {

				$insert_point = [
					'bldg_name' => $point['name'],
					'lat'       => $point['latitude'],
					'long'      => $point['longitude'],
					'alias'     => $point['alias'],
				];
				array_push($start_options,$insert_point);
				array_push($end_options,$insert_point);
			}
			echo json_encode([
				'start_options' => $start_options,
				'end_options' => $end_options
			]);
		}
		else {
			echo json_encode([
				'error' => $_SESSION['waypoints']['error']
			]);
		}
	}

	// When calling from js with a post variable functionname
	// run each functionname
	if(!empty($_POST['functionname'])) {
		if(is_array($_POST['functionname'])) {
			foreach($_POST['functionname'] as $function) {
				if(array_search($function,get_defined_functions()['user']) !== false) {
					$function();
				}
			}
		}
		else {
			if(array_search($_POST['functionname'],get_defined_functions()['user']) !== false) {
				$_POST['functionname']();
			}
		}
	}
