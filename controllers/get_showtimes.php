<?php

require("../models/Showtime.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

try{
    if (!isset($_GET["id"])){
        $showtimes= Showtime::all($mysqli);

        if(!$showtimes){
            $response["status"] = 404;
            $response["message"] = "No available showtimes";
            echo json_encode($response);
            return;
        }

        $response["showtimes"] = [];
        foreach($showtimes as $s){
            $response["showtimes"][] = $s->toArray();
        }
        echo json_encode($response); 
        return;

    }

    $id= $_GET["id"];
    $showtime= Showtime::find($mysqli, $id);
    if(!$showtime){
        $response["status"] = 404;
        $response["message"] = "Showtime not found";
        echo json_encode($response);
        return;
    }

    $response["showtime"] = $showtime->toArray();
    echo json_encode($response);

} catch(Exception $e){
    $response["status"] = 500;
    $response["message"] = "Something went wrong";
    echo json_encode($response);
}