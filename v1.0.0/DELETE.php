<?php
/**
 * UWF Map API - DELETE Protocol
 *
 * Holds all of what is needed for whenever a DELETE is called in the request
 *
 * @version: v1.0.0
 * @author:  Tyler Webb
 * @date:    2018-04-29
 * @info:    Capstone Spring 2018
 */

    require_once('lib.php');
    $db = connect_db();

    /**
     * Given an object and it's path delete it from the database and set API to refresh information on next call
     *
     * @param obj The array of objects to delete
     *
     * @return array An array of the building being affected and what was changed
     */
    function delete($obj) {
        global $db;

        if(count($obj) % 2 === 1) return; // Objects need keys

        $obj_id = array_pop($obj);
        $obj_type = array_pop($obj);

        switch($obj_type) {
            case 'rooms':
                if(empty($obj)) return; // Rooms need a building
                $bldg_id = array_pop($obj); // Should be building number
                $sql = "
                    UPDATE
                        rooms r
                    SET
                        rooms = r2.rooms
                    FROM (
                        VALUES
                            (
                                :bldg_id,
                                COALESCE(
                                    (
                                        SELECT rooms
                                        FROM (
                                            SELECT r3.building_num, array_to_json(array_agg(elem)) AS rooms
                                            FROM rooms r3, json_array_elements(r3.rooms) elem
                                            WHERE 1=1
                                                AND r3.building_num = :bldg_id
                                                AND elem->>'room_num' != :room_num
                                            GROUP BY 1
                                        ) y
                                    ),
                                    ('[]'::JSON)
                                )
                            )
                    ) AS r2(building_num, rooms)
                    WHERE 1=1
                        AND r.building_num = :bldg_id
                        AND r.building_num = r2.building_num
                        AND json_array_length(r2.rooms) < json_array_length(r.rooms);
                ";

                $run = $db->prepare($sql);
                $run->bindParam(':bldg_id',$bldg_id,PDO::PARAM_STR);
                $run->bindParam(':room_num',$obj_id,PDO::PARAM_STR);
                $run->execute();

                $_SERVER['REFRESH'] = true;
                return [$bldg_id => $obj_id];
                break;

            case 'buildings':
                $sql = "
                    DELETE FROM uwf_buildings
                    WHERE number = :bldg_id
                ";

                $run = $db->prepare($sql);
                $run->bindParam(':bldg_id',$obj_id,PDO::PARAM_STR);
                $run->execute();

                $_SERVER['REFRESH'] = true;
                return [$obj_type => $obj_id];
                break;
        }
    }