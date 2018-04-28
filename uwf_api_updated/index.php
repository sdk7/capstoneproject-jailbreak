<?php

    session_start();

    // Request looks like server.com/v1.0.0/apikey/GET/object1/key1/object2/key2/...
    // $_SERVER['REQUEST_URI'] = '/v1.0.0/apikey/GET/object1/key1/object2/key2/...'

    // ! Debugging purposes
    if($_SERVER['REQUEST_URI'] === '/reset_all') {
        unset($_SERVER['users']);
        unset($_SERVER['rooms']);
        unset($_SERVER['buildings']);
    }
    else {
        $req_str             = array_filter(explode('/',$_SERVER['REQUEST_URI']));
        $request['VERSION']  = array_shift($req_str);
        $request['KEY']      = array_shift($req_str);
        $request['PROTOCOL'] = array_shift($req_str);
        $request['OBJECTS']  = $req_str;
    }


    require_once(__DIR__ . '/' . $request['VERSION'] . '/' . 'lib.php');
    require_once(__DIR__ . '/' . $request['VERSION'] . '/' . 'GET.php');
    // require_once(__DIR__ . '/' . LIB . '/' . 'PUT.php');
    // require_once(__DIR__ . '/' . LIB . '/' . 'POST.php');
    // require_once(__DIR__ . '/' . LIB . '/' . 'DELETE.php');

    $db = connect_db();

    if(!isset($_SERVER['users']) || empty($_SERVER['users']))
        store_users($db);

    if( !$request['KEY'] || !verify_key($request['KEY'],$_SERVER['users'])) {
        echo json_encode(['error'=>'invalid key']);
    } else if( !$request['PROTOCOL'] || !in_array($request['PROTOCOL'],['GET','POST','PUT','DELETE'])) {
        echo json_encode(['error'=>'invalid protocol']);
    } else if(empty($request['OBJECTS'])) {
        echo json_encode(['error'=>'invalid object(s)']);
    } else {
        switch($request['PROTOCOL']) {
            case 'GET':
                echo json_encode(get_objects($request['OBJECTS'])); // GET.php
                break;
            case 'PUT':
                // echo json_encode(update($request,$_POST)); // PUT.php
                break;
            case 'POST':
                // echo json_encode(create($request,$_POST)); // POST.php
                break;
            case 'DELETE':
                // echo json_encode(del_objects($request,$_POST)); // DELETE.php
                break;
        }
    }
