<?php
	/**
	* Used to declared and implement general use functions for the test_site
	*
	* @author: Tyler Webb
	* @date:   2018-03-04
	*/

	include_once(__DIR__ . '/variables.php');

	/**
	* Connect to the pgsql database safely
	* @param: stringDBHost
	* @param: stringDBPort
	* @param: stringDBName
	* @param: stringDBUsername
	* @param: stringDBPassword
	*
	* @return: PHP Data Object connected to pgsql database
	*/
	function PDOMYConnect(
		$stringDBHost     = NULL,
		$stringDBPort     = NULL,
		$stringDBName     = NULL,
		$stringDBUsername = NULL,
		$stringDBPassword = NULL
	) {
		// Default values so you can just do PDOMYConnect()
		if(
			$stringDBHost        !== NULL
			&& $stringDBPort     !== NULL
			&& $stringDBName     !== NULL
			&& $stringDBUsername !== NULL
			&& $stringDBPassword !== NULL
		){
			$stringDBHost     = $host ;
			$stringDBPort     = $port ;
			$stringDBName     = $db   ;
			$stringDBUsername = $user ;
			$stringDBPassword = $pass ;
		}

		$dbPGSQL = false;
		$stringDBPortExtension = '';

		if(!empty($stringDBPort) && is_numeric($stringDBPort))
			$stringDBPortExtension = ';port=' . $stringDBPort;
		if(    (!empty($stringDBHost))
			&& (!empty($stringDBName))
			&& (!empty($stringDBUsername))
			&& (!empty($stringDBPassword)))
		{
			try
			{
				$dbPGSQL = new PDO(
					'pgsql:host='
						. $stringDBHost
						. $stringDBPortExtension
						. ';dbname='
						. $stringDBName,
					$stringDBUsername,
					$stringDBPassword
				);
			}
			catch (PDOException $e)
			{
				return false;
			}
		}
		else return false;

		return $dbPGSQL;
	}

	// Grab all of the files in the javascript folder
	function getjs() {
		$filesArray = array()                          ;
		$dir        = ($_POST['dir'] ?: 'js' )         ;
		$files      = scandir(__DIR__ . '/../' . $dir) ;

		// Already hardcoded in
		$hardcodedjs = 'main.js';
		if(($key = array_search($hardcodedjs, $files)) !== false) unset($files[$key]);
		$hardcodedjs = 'handlebars-v4.0.11.js';
		if(($key = array_search($hardcodedjs, $files)) !== false) unset($files[$key]);

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

	// @HACK
	// When calling from js with a post variable functionname
	// run each functionname. This is actually just cancer.
	// If this goes anywhere find a better way to do this
	if(!empty($_POST['functionname'])) {
		if(is_array($_POST['functionname']))
			foreach($_POST['functionname'] as $function)
				$function();
		else
			$_POST['functionname']();
	}
