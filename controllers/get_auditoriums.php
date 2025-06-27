<?php

require("../models/Auditorium.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

try{
    if (!isset($_GET["id"])){
        $auditoriums= Auditorium::all($mysqli);

        if(!$auditoriums){
            $response["status"] = 404;
            $response["message"] = "No available auditoriums";
            echo json_encode($response);
            return;
        }

        $response["auditoriums"] = [];
        foreach($auditoriums as $u){
            $response["auditoriums"][] = $u->toArray();
        }
        echo json_encode($response);
        return;

    }

    $id= $_GET["id"];
    $auditorium= Auditorium::find($mysqli, $id);
    if(!$auditorium){
        $response["status"] = 404;
        $response["message"] = "Auditorium not found";
        echo json_encode($response);
        return;
    }

    $response["auditorium"] = $auditorium->toArray();
    echo json_encode($response);

} catch(Exception $e){
    $response["status"] = 500;
    $response["message"] = "Something went wrong";
    echo json_encode($response);
}