<?php
/**
 * UWF Map API
 * 
 * API to add, update, delete, and retrieve information about the buildings and rooms of UWF
 * 
 * Request looks like server.com/v1.0.0/apikey/GET/object1/key1/object2/key2/...
 * 
 * @authors: Tyler Webb, Stewart Kaminer, Alexander Oldaker
 * @date: 2018-04-28
 * @info: Capstone Spring 2018
 */

    session_start();

    $req_str             = array_filter(explode('/',$_SERVER['REQUEST_URI']));
    array_shift($req_str); // ! Get rid of before going to production
    $request['VERSION']  = array_shift($req_str);
    $request['KEY']      = array_shift($req_str);
    $request['PROTOCOL'] = array_shift($req_str);
    $request['OBJECTS']  = $req_str;
    
    if(!is_dir(__DIR__ . '/' . $request['VERSION'])) {
        echo json_encode(['error' => 'invalid version: ' . $request['VERSION']]);
        http_response_code(400);
        die();
    }
    
    if( !isset($request['PROTOCOL']) || !in_array($request['PROTOCOL'],['GET','POST','PUT','DELETE'])) {
        echo json_encode(['errpr' => 'invalid protocol']);
        http_response_code(400);
        die();
    }

    require_once(__DIR__ . '/' . $request['VERSION'] . '/' . 'lib.php');
    require_once(__DIR__ . '/' . $request['VERSION'] . '/' . $request['PROTOCOL'] . '.php');

    $db = connect_db();

    if(!isset($_SERVER['users']) || empty($_SERVER['users']))
        $_SERVER['users'] = store_users($db);

    if( !$request['KEY'] || !verify_key($request['KEY'],$_SERVER['users'])) {
        echo json_encode(['error'=>'invalid key']);
        http_response_code(401);
        die();
    } else if(empty($request['OBJECTS'])) {
        echo json_encode(['error'=>'invalid object(s)']);
        http_response_code(400);
        die();
    } else {
        switch($request['PROTOCOL']) {
            case 'GET':
                $ret = get_objects($request['OBJECTS']);
                echo (empty($ret)) ? '' : json_encode($ret);
                if(empty($ret)) http_response_code(400);
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