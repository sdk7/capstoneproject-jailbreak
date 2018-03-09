<?php
    /**
     * Single page web application that utilizes the UWF location API
     *
     * @version: 1.0
     * @author:  Tyler Webb
     * @date:    2018-03-04
     * @info:    CIS4592 - Capstone Project
     */

    (!defined(LIB_FOLDER)) ?: define('LIB_FOLDER',"lib/");

/* Include Files */
    include_once(__DIR__ . LIB_FOLDER . 'ContentBlock.class.php')
    // Must be declared after any include files that define classes, otherwise classes won't exist for session
    session_start();
    include_once(__DIR__ . LIB_FOLDER . 'lib.php');

    $dbh = PDOMYConnect($host,$port,$db,$user,$pass);

    PrintHeader($jsPath,$jsFiles);

    // Main application goes here

    PrintFooter();

    $dbh = NULL;
