<?php

    require_once('lib.php');

    $db = connect_db();

    function get_objects($objects) {
        create_sql($objects);
    }

    function create_sql($obj) {
        $table = '';

        if(count($obj) % 2 === 0) { // Specific object
            $obj_id = array_pop($obj);
            $obj_type = array_pop($obj);

            switch($obj_type) {
            case 'rooms': $table = 'rooms'; break;
            case 'uwf_buildings': $table = 'uwf_buildings'; break;
            }
        }
        else { // An array of objects
        }
    }
