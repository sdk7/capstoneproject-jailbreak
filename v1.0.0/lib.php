<?php
/**
 * UWF Map API - lib
 *
 * Library of general purpose functions that is used throughout the API or doesn't have a better place to reside
 *
 * @version: v1.0.0
 * @author:  Tyler Webb
 * @date:    2018-04-29
 * @info:    Capstone Spring 2018
 */

    // Database connection information
    $user = 'JailbreakAdmin';
    $pass = 'JailbreakPassword';
    $host = "pgsql:host=scavengerdatabase.c86huxufzw7q.us-east-2.rds.amazonaws.com;port=5432;dbname=capstone";

    /**
     * Create a connection to the database into a PDO object
     *
     * @param host_string The string to connect to the database @default NULL
     * @param username Database username @default NULL
     * @param password Database password @default NULL
     *
     * @return PDO
     */
    function connect_db($host_string = NULL, $username = NULL, $password = NULL) {
        global $user, $pass, $host;

        // Defaults to the global variables so you can just call connect_db();
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

    /**
     * Get all user information and return array indexed by user keys
     *
     * @param dbc Database PDO Connection
     * @return array Array of user information
     *      [
     *          'key1' => ['username1','key1','extra1'],
     *          'key2' => ['username2','key2','extra2'],
     *           ...
     *      ]
     */
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

    /**
     * Since users are indexed by their key we just check to see if the array_key_exists in the user array
     *
     * @param key Key to check for
     * @param array The array we're checking
     *
     * @return boolean
     */
    function verify_key($key, $array) {
        return array_key_exists($key,$array);
    }

    /**
     * Creates user
     *
     * @param dbc Database PDO connection
     * @param username Username of the new user
     * @param key API key of the new user if you don't want use the random one
     * @param extra Any extra options in JSON form
     *      For being able to update information via API calls the user must have a
     *      JSON attribute admin like so:
     *          $extra = '{ "admin" : "true" }'
     *
     * @return user_info Returns an array of the username and key
     *      [
     *          'username' => $username,
     *          'key'      => $key
     *      ]
     */
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

    /**
     *  Creates random string. Stolen from https://gist.github.com/irazasyed/5382685
     *
     * @param type The kind of random string you want generated
     * @param length The length of the string to be generated
     *
     * @return string
     */
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

    /**
     * Checks whether the user with the given key has the attribute 'admin' in their extra on uwf_users
     *
     * @param dbc Database PDO connection
     * @param key User key to check
     *
     * @return boolean
     */
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