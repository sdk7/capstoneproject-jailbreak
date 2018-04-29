<?php

    // $user = 'JailbreakAdmin';
    // $pass = 'JailbreakPassword';
    // $host = "pgsql:host=scavengerdatabase.c86huxufzw7q.us-east-2.rds.amazonaws.com;port=5432;dbname=ScavengerDatabase";

    function connect_db($host_string = 'pgsql:host=scavengerdatabase.c86huxufzw7q.us-east-2.rds.amazonaws.com;port=5432;dbname=capstone', $username = 'JailbreakAdmin', $password = 'JailbreakPassword') {
        try {
            $pdo = new PDO(
                $host_string,
                $username,
                $password
            );

            return $pdo;
        } catch(PDOException $e) {
            echo json_encode($e->getMessage());
            die();
        }
    }

    function store_users($dbc) {
        $sql = "SELECT username::TEXT, key::TEXT, extra::TEXT FROM uwf_users;";

        $run = $dbc->prepare($sql);
        $run->execute();
        $vals = $run->fetchall();
        $ret = array();

        foreach($vals AS $k => $v)
            $ret[$v['key']] = $v;

        return $ret;
    }

    function verify_key($key, $array) {
        return array_key_exists($key,$array);
    }

    function create_user($dbc, $username, $key = NULL, $extra = NULL) {
        $sql = "
            INSERT INTO
                uwf_users u (username, key, extra)
            VALUES
                (':username', ':key'," . ($extra) ? "':extra'::JSON" : "''" .");
        ";

        $key = $username . '_' . ($key) ?: generate_random_string();

        $run = $dbc->prepare();
        $run->bindParam(':username',$username,PDO::PARAM_STR);
        $run->bindParam(':key',$key,PDO::PARAM_STR);
        if(!empty($extra)) $run->bindParam(':extra',json_encode($extra),PDO::PARAM_STR);
        $run->execute();

        return [$username => $key];
    }

    function generate_random_string($length = 10) {
        $nps = "";
        for($i=0;$i<$length;$i++)
        {
            $nps .= chr( (mt_rand(1, 36) <= 26) ? mt_rand(97, 122) : mt_rand(48, 57 ));
        }
        return $nps;
    }

    function is_admin($dbc,$key) {
        $admin = false;

        $sql = "
            SELECT
                CASE
                    WHEN extra->'admin' IS NOT NULL
                    THEN 1 ELSE 0
                END AS admin
            FROM
                uwf_users
            WHERE
                key = :u_key
        ";
        
        $run = $dbc->prepare($sql);
        $run->bindParam(':u_key',$key,PDO::PARAM_STR);
        $run->execute();
        $vals = $run->fetchall();
        $val = $vals[0]['admin'];

        return ($val) ? true : false;
    }