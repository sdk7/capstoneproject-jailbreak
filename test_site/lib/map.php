<?php
	function getlocations() {
		// Where we would call API
		if(!isset($_SESSION['waypoints']) || $_SESSION['waypoints'] === NULL) {
			$func               = 'get_all_waypoints';
			$key                = 'apikeygoeshere';
			// $get_waypoints_url  = 'https://capstone-jailbreak-taw39.c9users.io/uwf_api/uwf_api.php?';
			$get_waypoints_url  = 'http://ec2-18-219-246-128.us-east-2.compute.amazonaws.com/capstone/uwf_api/uwf_api.php?';
			$get_waypoints_url .= "call={$func}";
			$get_waypoints_url .= "&key={$key}";
			$params             = '';

			$_SESSION['waypoints'] = json_decode(file_get_contents($get_waypoints_url),true);
		}
		$start_options = array();
		$end_options   = array();
		if(!isset($_SESSION['waypoints']['error']))	{
			foreach($_SESSION['waypoints'] as $point) {

				$insert_point = [
					'bldg_name' => $point['name'],
					'lat'       => $point['coordinates'][1],
					'long'      => $point['coordinates'][0]
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
