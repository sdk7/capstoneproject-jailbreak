<?php
	function getlocations() {
		// Where we would call API
		echo json_encode([
			'start_options' => [
				[ 'bldg_name' => 'test', 'lat' => '30.544317', 'long' => '-87.216088' ],
				[ 'bldg_name' => 'stet', 'lat' => '30.554327', 'long' => '-87.216078' ],
				[ 'bldg_name' => 'etts', 'lat' => '30.534312', 'long' => '-87.216096' ],
			],
			'end_options' => [
				[ 'bldg_name' => 'test', 'lat' => '30.544317', 'long' => '-87.216088' ],
				[ 'bldg_name' => 'stet', 'lat' => '30.554327', 'long' => '-87.216078' ],
				[ 'bldg_name' => 'etts', 'lat' => '30.534313', 'long' => '-87.216096' ],
			]
		]);
	}

	// When calling from js with a post variable functionname
	// run each functionname
	if(!empty($_POST['functionname'])) {
		if(is_array($_POST['functionname']))
			foreach($_POST['functionname'] as $function)
				$function();
		else
			$_POST['functionname']();
	}
