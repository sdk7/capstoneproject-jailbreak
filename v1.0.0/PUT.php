<?php
/**
 * UWF Map API - PUT
 *
 * Creates functions that handle all of the API PUT protocol requests
 *
 * @version: v1.0.0
 * @author:  Tyler Webb
 * @date:    2018-04-29
 * @info:    Capstone Spring 2018
 */

    require_once('lib.php');
    $db = connect_db();

    /**
     * Given an object type and what's going to be saved we create the records in the database
     *
     * @param obj The object type
     * @param info The information we're storing
     *
     * @return array What we've saved to the database
     */
    function create($obj,$info) {
        global $db;

        $obj_type = array_pop($obj);

        switch($obj_type) {
            case 'rooms':
                // Creates a new rooms record or updates an existing building by just appending to
                // the end of the rooms JSON array. Unfortunately doesn't check whether the room exists already.
                if(empty($obj)) return; // Rooms need a building_num to attach to
                $bldg_id = array_pop($obj);
                $sql_upsert = "
                    INSERT INTO
                        rooms(building_num,rooms)
                    VALUES
                            (:bldg_id,(:info)::JSON)
                    ON CONFLICT (building_num)
                    DO
                        UPDATE
                        SET
                            rooms = (rooms.rooms::JSONB || (:info)::JSONB)::JSON
                        WHERE
                            rooms.building_num = :bldg_id;
                ";

                $run = $db->prepare($sql_upsert);
                $run->bindParam(':bldg_id',$bldg_id,PDO::PARAM_STR);
                $run->bindParam(':info',$info['room_info'],PDO::PARAM_STR);
                $run->execute();

                $_SERVER['REFRESH'] = true;
                return [$bldg_id => $info];
                break;
            case 'buildings':
                // Insert building into uwf_buildings unless number already exists then do nothing
                $sql_insert = "
                    INSERT INTO
                        uwf_buildings(name, alias,number,type,latitude,longitude,extra,deleted)
                    VALUES
                        (
                            :name,
                            :alias,
                            :num,
                            'BLDG',
                            (:lat)::NUMERIC,
                            (:long)::NUMERIC,
                            (:extra)::JSON,
                            false
                        )
                ";

                $run = $db->prepare($sql_insert);
                $run->bindParam(':name',$info['name'],PDO::PARAM_STR);
                $run->bindParam(':alias',$info['alias'],PDO::PARAM_STR);
                $run->bindParam(':num',$info['num'],PDO::PARAM_STR);
                $run->bindParam(':lat',$info['lat'],PDO::PARAM_STR);
                $run->bindParam(':long',$info['long'],PDO::PARAM_STR);
                $run->bindParam(':extra',$info['extra'],PDO::PARAM_STR);
                $run->execute();

                $_SERVER['REFRESH'] = true;
                return ['BLDG' => json_encode($info)];
                break;
            case 'users':
                // Creates a user and returns their username and key
                $name  = $info['username'];
                $key   = (empty($info['key'])) ? NULL : $info['key'];
                $extra = (empty($info['extra'])) ? NULL : $info['extra'];

                $ret   = create_user($db,$name,$key,$extra);

                $_SERVER['REFRESH'] = true;
                return $ret;
                break;
        }
    }