<?php

	$func = 'get_all_waypoints';
	$url  = 'http://localhost/capstone/uwf_api/uwf_api.php?';
	$url .= "call={$func}";
	//$url .= 'functionname[]=' . implode('&functionname[]=' . array_map('urlencode', $func));
	$params = '';

	echo '<pre>';
	var_dump(file_get_contents($url));
	echo '</pre>';