<?php
	/**
	* Used to declared and implement general use functions for the test_site
	*
	* @author: Tyler Webb
	* @date:   2018-03-04
	*/

	include_once(__DIR__ . '/variables.php');

	// Grab all of the files in the javascript folder
	function getjs() {
		$filesArray = array()                          ;
		$dir        = ($_POST['dir'] ?: 'js' )         ;
		$files      = scandir(__DIR__ . '/../' . $dir) ;

		// Already hardcoded in
		$hardcodedjs = [
			'main.js',
			'handlebars-v4.0.11.js'
		];
		foreach($hardcodedjs as $js)
			if(($key = array_search($js, $files)) !== false) unset($files[$key]);

		foreach($files as $file)
			if($file != '.' && $file != '..')
				array_push($filesArray,$file);

		foreach($filesArray as $k => $v) {
			$file_parts = pathinfo(__DIR__ . '/../' . $dir . '/' . $v);

			if($file_parts['extension'] === 'js')
				$filesArray[$k] = [
					'name'  => $v,
					'js_id' => $file_parts['filename']
				];
			else
				unset($filesArray[$k]);
		}

		echo json_encode($filesArray);
	}

	// Grab all of the handlebars templates in the handlebars directory
	function gethandlebars() {
		$filesArray = array()                            ;
		$dir        = $_POST['dir'] ?: 'html/handlebars' ;
		$files      = scandir(__DIR__ . '/../' . $dir)   ;

		foreach($files as $file)
			if($file !== '.' && $file !== '..')
				array_push($filesArray,$file);

		foreach($filesArray as $k => $v) {
			$filepath   = (__DIR__ . '/../' . $dir . '/' . $v);
			$file_parts = pathinfo($filepath);

			if($file_parts['extension'] === 'html')
				$filesArray[$k] = [
					'template_name' => $file_parts['filename'],
					'file_name'     => $v,
					'html'          => html_entity_decode(file_get_contents($filepath))
				];
			else
				unset($filesArray[$k]);
		}

		echo json_encode($filesArray);
	}

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
