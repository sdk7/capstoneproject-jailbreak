<?php
	/**
	 * Single page web application that utilizes the UWF location API
	 *
	 * @version: 1.0
	 * @author:  Tyler Webb
	 * @date:    2018-03-04
	 * @info:    CIS4592 - Capstone Project
	 */

	/* Include Files */
	$LIB_FOLDER  = '/lib/';
	$HTML_FOLDER = '/html/';
	session_start(); // Must be declared after any include files that define classes
	require_once(__DIR__ . $LIB_FOLDER . 'lib.php');

	readfile(__DIR__ . $HTML_FOLDER . 'main.html');
