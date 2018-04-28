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