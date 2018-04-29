<?php
/**
 * UWF Map API - GET
 *
 * Creates functions that handle all of the API GET protocol requests
 *
 * @version: v1.0.0
 * @author:  Tyler Webb
 * @date:    2018-04-29
 * @info:    Capstone Spring 2018
 */

    require_once('lib.php');
    $db = connect_db();

    // Refresh server variable holding building information
    if(!isset($_SERVER['buildings']) || empty($_SERVER['buildings']) || $_SERVER['REFRESH'])
        $_SERVER['buildings'] = store_buildings($db);

    // Refresh server variable holding rooms information
    if(!isset($_SERVER['rooms']) || empty($_SERVER['rooms']) || $_SERVER['REFRESH'])
        $_SERVER['rooms'] = store_rooms($db);

    /**
     * Grabs all of the building information and returns an array of buildings indexed by their number
     *
     * @param dbc Database PDO Connection
     *
     * @return array
     *      [
     *          'number' => ['id','name','alias','number','type','latitude','longitude','extra','deleted'],
     *          ...
     *      ]
     */
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

    /**
     * Grabs all of the rooms of all buildings and returns an array of rooms indexed by their building number and room number
     *
     * @param dbc Database PDO Connetion
     *
     * @return array
     *      [
     *          'building_num' => [
     *              'room_num' => [<room_info>]
     *          ]
     *      ] -- Note that <room_info> is the decoded JSON from what is stored in the rooms table so there isn't anything known
     */
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

    /**
     * Given an array of objects find the corresponding information and return an array
     *
     * @param obj Array of objects and ids
     *
     * @return array Array from the API server's buildings or rooms variables. NULL if not found
     */
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

    // Everything has been updated
    $_SERVER['REFRESH'] = false;