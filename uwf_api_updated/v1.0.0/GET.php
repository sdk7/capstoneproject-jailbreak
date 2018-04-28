<?php

    require_once('lib.php');
    $db = connect_db();

    if(!isset($_SERVER['buildings']) || empty($_SERVER['buildings']))
        $_SERVER['buildings'] = store_buildings($db);

    if(!isset($_SERVER['rooms']) || empty($_SERVER['rooms']))
        $_SERVER['rooms'] = store_rooms($db);

    function store_buildings($dbc) {
        $sql = "SELECT * FROM uwf_buildings WHERE type = 'BLDG'";

        $run = $dbc->prepare($sql);
        $run->execute();
        $vals = $run->fetchall();
        $ret = array();

        foreach($vals as $k => $v)
            $ret[$v['number']] = $v;

        return $ret;
    }

    function store_rooms($dbc) {
        $sql = "SELECT r.building_num::TEXT, a.x->>'room_num' AS room_num, a.x::TEXT AS info FROM rooms r, json_array_elements(r.rooms) a(x)";

        $run = $dbc->prepare($sql);
        $run->execute();
        $vals = $run->fetchall();
        $ret = array();

        foreach($vals as $k => $v)
            $ret[$v['building_num']][$v['room_num']] = json_decode($v['info']);

        return $ret;
    }

    function get_objects($obj) {
        if(count($obj) % 2 === 0){ // $obj contains key to last object
            $obj_id   = array_pop($obj);
            $obj_type = array_pop($obj);

            switch($obj_type) {
                case 'rooms': // Expects the other objects as 'buildings' and 'id'
                    if(empty($obj)) return ['ERROR' => 'Expected building id'];
                    $bldg_id = array_pop($obj);
                    return $_SERVER['rooms'][$bldg_id][$obj_id];
                    break;
                case 'buildings':
                    return $_SERVER['buildings'][$obj_id];
                    break;
            }
        }
        else { // No key on last object return large array
            $obj_type = array_pop($obj);

            switch($obj_type) {
                case 'rooms':
                    if(empty($obj)) return $_SERVER['rooms'];
                    $bldg_id = array_pop($obj);
                    return $_SERVER['rooms'][$bldg_id];
                    break;
                case 'buildings':
                    return $_SERVER['buildings'];
                    break;
            }
        }
    }