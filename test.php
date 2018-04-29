<?php

    $url = 'https://capstone-jailbreak-taw39.c9users.io/index.php/v1.0.0/apikeygoeshere/POST/buildings/5/rooms/8';
    $data = array('room_num' => '8','bldg_id' => '5', 'room_info' => '{"room_num":"8","test":"t"}');;
    
    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    echo $result;