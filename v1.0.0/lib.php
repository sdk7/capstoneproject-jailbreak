<?php

    $user = 'JailbreakAdmin';
    $pass = 'JailbreakPassword';
    $host = "pgsql:host=scavengerdatabase.c86huxufzw7q.us-east-2.rds.amazonaws.com;port=5432;dbname=ScavengerDatabase";

    function connect_db($host_string = NULL, $username = NULL, $password = NULL) {
        global $user, $pass, $host;

        $host_string = (!empty($host_string)) ? $host_string : $host;
        $username    = (!empty($username))    ? $username    : $user;
        $password    = (!empty($password))    ? $password    : $pass;

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
                uwf_users (username, key, extra)
            VALUES
                (:username, :key," .(($extra) ? "(:extra)::JSON" : "'{}'::JSON").");
        ";

        $key = $username . '_' . (($key) ?: generate_random_string());
        $user = array('username' => $username, 'key' => $key);

        $run = $dbc->prepare($sql);
        $run->bindParam(':username',$username,PDO::PARAM_STR);
        $run->bindParam(':key',$key,PDO::PARAM_STR);
        if(!empty($extra)) $run->bindParam(':extra',json_encode($extra),PDO::PARAM_STR);
        $run->execute();

        return $user;
    }

    // https://gist.github.com/irazasyed/5382685
    function generate_random_string($type = 'alphanum', $length = 8) {
        switch($type) {
            case 'basic'    : return mt_rand();
                break;
            case 'alpha'    :
            case 'alphanum' :
            case 'num'      :
            case 'nozero'   :
                    $seedings             = array();
                    $seedings['alpha']    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $seedings['alphanum'] = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $seedings['num']      = '0123456789';
                    $seedings['nozero']   = '123456789';

                    $pool = $seedings[$type];

                    $str = '';
                    for ($i=0; $i < $length; $i++)
                    {
                        $str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
                    }
                    return $str;
                break;
            case 'unique'   :
            case 'md5'      :
                        return md5(uniqid(mt_rand()));
                break;
        }
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