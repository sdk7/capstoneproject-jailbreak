<?php
/**
 * UWF Map API
 *
 * API to add, update, delete, and retrieve information about the buildings and rooms of UWF
 *
 * Request looks like server.com/v1.0.0/apikey/GET/object1/key1/object2/key2/...
 *
 * Status Codes:
 *      200 OK
 *      201 Created
 *      204 Empty Content
 *      400 Bad Request
 *      401 Unauthorized
 *
 * @authors: Tyler Webb, Stewart Kaminer, Alexander Oldaker
 * @date: 2018-04-29
 * @info: Capstone Spring 2018
 */

    session_start();

    // Parses request into usable entities
    //      /index.php/v.1.0.0/apikeygoeshere/objects/key/...
    $req_str             = array_filter(explode('/',$_SERVER['REQUEST_URI']), 'strlen');
    array_shift($req_str); // Gets rid of index.php
    $request['VERSION']  = array_shift($req_str);
    $request['KEY']      = array_shift($req_str);
    $request['PROTOCOL'] = array_shift($req_str);
    $request['OBJECTS']  = $req_str;

    // Verifies version folder exists before being called
    if(!is_dir(__DIR__ . '/' . $request['VERSION'])) {
        echo json_encode(['error' => 'invalid version: ' . $request['VERSION']]);
        http_response_code(400);
        die();
    }

    // Verifies the PROTOCOL is something being handled by the API
    if( !isset($request['PROTOCOL']) || !in_array($request['PROTOCOL'],['GET','POST','PUT','DELETE'])) {
        echo json_encode(['error' => 'invalid protocol']);
        http_response_code(400);
        die();
    }

    // Require only what's needed
    require_once(__DIR__ . '/' . $request['VERSION'] . '/' . 'lib.php');
    require_once(__DIR__ . '/' . $request['VERSION'] . '/' . $request['PROTOCOL'] . '.php');

    if(!isset($_SERVER['REFRESH'])) $_SERVER['REFRESH'] = false;
    $db = connect_db();

    // Update user list if user list doesn't exist or if it needs to be refreshed
    if(!isset($_SERVER['users']) || empty($_SERVER['users']) || $_SERVER['REFRESH'])
        $_SERVER['users'] = store_users($db);

    // Verify the given key exists
    if( !$request['KEY'] || !verify_key($request['KEY'],$_SERVER['users'])) {
        echo json_encode(['error'=>'invalid key']);
        http_response_code(401);
        die();
    } else if(empty($request['OBJECTS'])) {
        // Verify the request is providing some kind of object
        echo json_encode(['error'=>'invalid object(s)']);
        http_response_code(400);
        die();
    } else {
        // Handle what the user wants to do
        switch($request['PROTOCOL']) {
            case 'GET':
                $ret = get_objects($request['OBJECTS']);
                echo (empty($ret)) ? '' : json_encode($ret);
                http_response_code((empty($ret)) ? 400 : 200);
                break;
            case 'POST':
                if(is_admin($db,$request['KEY'])) {
                    $ret = update($request['OBJECTS'],$_POST);
                    echo (empty($ret)) ? '' : json_encode($ret);
                    http_response_code((empty($ret)) ? 400 : 200);
                }
                else {
                    echo json_encode(['error'=>'invalid permissions']);
                    http_response_code(401);
                    die();
                }
                break;
            case 'PUT':
                if(is_admin($db,$request['KEY'])) {
                    $ret = create($request['OBJECTS'],$_POST);
                    echo (empty($ret)) ? '' : json_encode($ret);
                    http_response_code((empty($ret)) ? 400 : 201);
                }
                else {
                    echo json_encode(['error'=>'invalid permissions']);
                    http_response_code(401);
                    die();
                }
                break;
            case 'DELETE':
                if(is_admin($db,$request['KEY'])) {
                    $ret = delete($request['OBJECTS']);
                    // Since DELETE returns 204 there's no need to echo anything
                    http_response_code((empty($ret)) ? 400 : 204);
                }
                else {
                    echo json_encode(['error'=>'invalid permissions']);
                    http_response_code(401);
                    die();
                }
                break;
        }
    }