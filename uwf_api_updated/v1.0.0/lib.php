<?php

    $user = 'JailbreakAdmin';
    $pass = 'JailbreakPassword';
    $host = "pgsql:host=scavengerdatabase.c86huxufzw7q.us-east-2.rds.amazonaws.com;port=5432;dbname=ScavengerDatabase";

    function connect_db($host_string = 'JailbreakAdmin', $username = $user, $password = $password) {
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
