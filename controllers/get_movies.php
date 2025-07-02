<?php

require("../models/Movie.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

try{
    if (!isset($_GET["id"])){
        $movies= Movie::all($mysqli);

        if(!$movies){
            $response["status"] = 404;
            $response["message"] = "No available movies";
            echo json_encode($response);
            return;
        }

        $response["movies"] = [];
        foreach($movies as $m){
            $response["movies"][] = $m->toArray();
        }
        echo json_encode($response);
        return;

    }

    $id= $_GET["id"];
    $movie= Movie::find($mysqli, $id);
    if(!$movie){
        $response["status"] = 404;
        $response["message"] = "Movie not found";
        echo json_encode($response);
        return;
    }

    $response["movies"] = $movie->toArray();
    echo json_encode($response);

} catch(Exception $e){
    $response["status"] = 500;
    $response["message"] = "Something went wrong";
    echo json_encode($response);
}