<?php
    $user = 'JailbreakAdmin';
    $pass = 'JailbreakPassword';
    $host = "pgsql:host=scavengerdatabase.c86huxufzw7q.us-east-2.rds.amazonaws.com;port=5432;dbname=ScavengerDatabase";
    
    try
    {
        $pdo = new PDO(
            $host,
            $user,
            $pass
        );
        
        $sqlString = <<<SQL
    SELECT
        *
    FROM
        pg_tables
    WHERE 1=1
        AND schemaname != 'pg_catalog'
    ;
SQL;

        $sql = $pdo->prepare($sqlString);
        if(!$sql->execute())
            echo 'error';
        else
            $return = $sql->fetchall();
            
        // echo $return[0][0] . '<br/>';
        // echo $return[0]['schemaname'] . '<br/>';
        
        var_dump($return);
        
        
        $pdo = NULL;
        $sql = NULL;
    }
    catch(PDOException $e)
    {
        print "Error:<br/>" . $e->getMessage() . "<br/>";
        die();
    }
