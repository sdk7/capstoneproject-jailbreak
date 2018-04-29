<?php

    $url = 'https://capstone-jailbreak-taw39.c9users.io/index.php/v1.0.0/apikeygoeshere/DELETE/buildings/TEST';
    $data = array(
        'name' => 'TESTES',
        'number' => '9001',
        'latitude' => '0.000',
        'longitude' => '-90.000',
    );
    
    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'GET',
            'content' => http_build_query($data)
        )
    );
    
    $context = stream_context_create($options);
    $ret = file_get_contents($url, false, $context);
    echo $ret;
