<?php
    /**
     * Holds variables used throughout the test_site
     *
     * @author: Tyler Webb
     * @date:   2018-03-04
     */

    /* Defines */
    (defined('CR')) ?: define('CR',"\r\n"); // Carriage Returns

    /* Variables */
    $host = ''                        ;
    $port = '5432'                    ;
    $db   = 'dbname=ScavengerDatabase';
    $user = 'JailbreakUser'           ;
    $pass = 'JailbreakPassword'       ;

    $jsPath  = $sitePath . 'js/'; 
    $jsFiles = [
        'handlebars-v4.0.11.js'
    ]; 
