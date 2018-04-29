<?php

    require_once('lib.php');
    $db = connect_db();
    $_SERVER['REFRESH'] = true;

    function update($obj,$info) {
        global $db;

        if(count($obj) % 2 === 1) return; // Objects need keys

        $obj_id = array_pop($obj);
        $obj_type = array_pop($obj);

        switch($obj_type) {
            case 'rooms':
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

                return [$bldg_id => $info['room_info']];
                break;
            case 'buildings':
                $sql = "UPDATE uwf_buildings SET id = id";
                foreach($info as $k => $v) {
                    if($k != 'latitude' || $k != 'longitude' || $k != 'extra') {
                        $sql .= ", {$k} = (:{$k})";
                    } else if ($k === 'extra') {
                        $sql .= ", {$k} = (:{$k})::JSON";
                    } else {
                        $sql .= ", {$k} = (:{$k})::NUMERIC";
                    }
                }
                $sql .= " WHERE number = :bldg_id";
                
                $run = $db->prepare($sql);
                foreach($info as $k => &$v)
                    $run->bindParam(":{$k}",$v,PDO::PARAM_STR);
                $run->bindParam(':bldg_id',$obj_id,PDO::PARAM_STR);
                $run->execute();

                return [$obj_id => json_encode($info)];
                break;
        }

    }