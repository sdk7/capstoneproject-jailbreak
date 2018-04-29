<?php

    require_once('lib.php');
    $db = connect_db();
    $_SERVER['REFRESH'] = true;

    function create($obj,$info) {
        global $db;

        $obj_type = array_pop($obj);

        switch($obj_type) {
            case 'rooms':
                if(empty($obj)) return;
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
                            rooms = (rooms::JSONB || (:info)::JSONB)::JSON
                        WHERE
                            building_num = :bldg_id;
                ";

                $run = $db->prepare($sql_upsert);
                $run->bindParam(':bldg_id',$bldg_id,PDO::PARAM_STR);
                $run->bindParam(':info',json_encode($info),PDO::PARAM_STR);
                $run->execute();

                return [$bldg_id => json_encode($info)];
                break;
            case 'buildings':
                $sql_insert = "
                    INSERT INTO
                        buildings(name, alias,number,type,latitude,longitude,extra,deleted)
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

                return ['BLDG' => json_encode($info)];
                break;
            case 'users':
                $name = $info['username'];
                $key = (empty($info['key'])) ? NULL : $info['key'];
                $extra (empty($info['extra'])) ? NULL : $info['extra'];
                create_user($db,$name,$key,$extra);

                return [$name => $key];
        }
    }