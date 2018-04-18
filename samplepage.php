<?php
    $origin = "university+of+west+florida+conference+center";
    $destination = "university+of+west+florida+bookstore";
    $key = "AIzaSyALj7RBA1I7YNGnH3YFECOnzrH-0kz1Joo";
    $urlstring = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $origin . "&destination=" . $destination . "&mode=walking&key=" . $key;
    
    $urlcontents = file_get_contents($urlstring);
    $response = json_decode($urlcontents, true);
    //var_dump ($response ["routes"][0]["legs"][0]["steps"]);
   