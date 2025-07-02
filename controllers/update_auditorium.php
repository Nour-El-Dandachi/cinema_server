<?php

require("../models/Auditorium.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data["id"])) {
    $response["status"] = 400;
    $response["message"] = "Missing auditorium ID";
    echo json_encode($response);
    return;
}

$id = $data["id"];
unset($data["id"]);

$auditorium = Auditorium::find($mysqli, $id);

if(!$auditorium){
    $response["status"] = 404;
    $response["message"] = "Auditorium not found";
    echo json_encode($response);
    return;
}

$updated = $auditorium->update($mysqli, $data);

if(!$updated){
    $response["status"] = 500;
    $response["message"] = "Failed to update auditorium";
    echo json_encode($response);
    return;
}

$response["message"] = "Auditorium updated successfully";
echo json_encode($response);