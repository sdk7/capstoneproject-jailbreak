<?php
/**
 * UWF Map API - POST
 *
 * Handles all requests where POST is called
 *
 * @version: v1.0.0
 * @author:  Tyler Webb
 * @date:    2018-04-29
 * @info:    Capstone Spring 2018
 */

    require_once('lib.php');
    $db = connect_db();

    /**
     * Given a specific object and an array of information, update an existing record in the database
     *
     * @param obj Array of objects and their corresponding IDs
     * @param info What to update the object information into
     *
     * @return array Array of what was updated
     */
    function update($obj,$info) {
        global $db;

        if(count($obj) % 2 === 1) return; // Objects need keys

        $obj_id = array_pop($obj);
        $obj_type = array_pop($obj);

        switch($obj_type) {
            case 'rooms':
                // First we remove the room and replace if it exists
                // Otherwise it will just add it the rooms for the given building
                if(empty($obj)) return; // Rooms need a building
                $bldg_id = array_pop($obj);
                if(!$info['room_num']) return;
                $sql = <<<SQL
    UPDATE
        rooms r
    SET
        rooms = (r2.rooms::JSONB || (:room_info)::JSONB)::JSON
    FROM (
        VALUES
            (
                :bldg_id,
                COALESCE (
                    (
                        SELECT rooms
                        FROM (
                            SELECT
                                r3.building_num,
                                array_to_json(array_agg(elem)) AS rooms
                            FROM
                                rooms r3,
                                json_array_elements(r3.rooms) elem
                            WHERE 1=1
                                AND r3.building_num = :bldg_id
                                AND elem->>'room_num' != :room_num
                            GROUP BY
                                1
                        ) y
                    ),
                    ('[]'::JSON)
                )
            )
    ) r2 (building_num, rooms)
    WHERE 1=1
        AND r.building_num = :bldg_id
        AND r.building_num = r2.building_num
        AND json_array_length(r2.rooms) < json_array_length(r.rooms);
SQL;

                $run = $db->prepare($sql);
                $run->bindParam(':room_info',$info['room_info'],PDO::PARAM_STR);
                $run->bindParam(':room_num',$info['room_num'],PDO::PARAM_STR);
                $run->bindParam(':bldg_id',$bldg_id,PDO::PARAM_STR);
                $run->execute();
                $run = NULL;

                $_SERVER['REFRESH'] = true;
                return [$bldg_id => $info['room_info']];
                break;
            case 'buildings':
                // Since uwf_buildings isn't completely JSON we have to create sql that only updates the given columns
                $sql = "UPDATE uwf_buildings SET id = id";
                foreach($info as $k => $v) {
                    if($k != 'latitude' || $k != 'longitude' || $k != 'extra') {
                        $sql .= ", {$k} = (:{$k})";
                    } else if ($k === 'extra') {
                        $sql .= ", {$k} = (:{$k})::JSON"; // Because TEXT != JSON
                    } else {
                        $sql .= ", {$k} = (:{$k})::NUMERIC"; // Because TEXT != NUMERIC
                    }
                }
                $sql .= " WHERE number = :bldg_id";

                $run = $db->prepare($sql);
                foreach($info as $k => &$v)
                    $run->bindParam(":{$k}",$v,PDO::PARAM_STR);
                $run->bindParam(':bldg_id',$obj_id,PDO::PARAM_STR);
                $run->execute();

                $_SERVER['REFRESH'] = true; // We deleted something so we should show this the next time we try to GET
                return [$obj_id => json_encode($info)];
                break;
        }

    }