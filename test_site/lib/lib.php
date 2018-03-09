<?php
    /**
     * Used to declared and implement general use functions for the test_site
     *
     * @author: Tyler Webb
     * @date:   2018-03-04
     */

    include_once(__DIR__ . 'variables.php');

    /**
     * Used for testing. Echos variable `pretty`
     * @TODO: DELETE THIS BEFORE PRODUCTION
     */
    function pr($data)
    {
        echo "<pre>" . var_dump($data) . "</pre>";
    }

    /**
     * Connect to the pgsql database safely
     * @param: stringDBHost
     * @param: stringDBPort
     * @param: stringDBName
     * @param: stringDBUsername
     * @param: stringDBPassword
     *
     * @return: PHP Data Object connected to pgsql database
     */
    function PDOMYConnect($stringDBHost,$stringDBPort,$stringDBName,$stringDBUsername,$stringDBPassword)
    {
        $dbPGSQL = false;
        $stringDBPortExtension = '';

        if(!empty($stringDBPort) && is_numeric($stringDBPort))
            $stringDBPortExtension = ';port=' . $stringDBPort;
        if(
        if(    (!empty($stringDBHost))
            && (!empty($stringDBName))
            && (!empty($stringDBUsername))
            && (!empty($stringDBPassword)))
        {
            try
            {
                $dbPGSQL = new PDO(
                    'pgsql:host='
                        . $stringDBHost
                        . $stringDBPortExtension
                        . ';dbname='
                        . $stringDBName,
                    $stringDBUsername,
                    $stringDBPassword
                );
            }
            catch (PDOException $e)
            {
                return false;
            }
        }
        else return false;

        return $dbPGSQL;
    }

    function PrintHeader($jsPath = NULL, $jsScript = NULL, $onLoadFunctionString = NULL)
    {
        echo <<<HTML1
<!DOCTYPE HTML>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
<head>
HTML1;

        if(is_array($jsScript))
            foreach($jsScript as $js)
                echo "    <script src=\"{$jsPath}{$js}\"></script>" . CR;

        echo <<<HTML2
    <title>Test Page</title>
</head>
<body onload="{$onLoadFunctionString}">
HTML2;
    }

    function PrintFooter
    {
        echo <<<HTML1
</body>
</html>
HTML1;
    }
