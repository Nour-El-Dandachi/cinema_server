<?php

require("../models/Auditorium.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);

if (
    !$data || 
    !isset($data["name"]) ||
    !isset($data["seat_layout"])
) {
    $response["status"] = 400;
    $response["message"] = "Missing required fields";
    echo json_encode($response);
    return;
}


$auditorium= Auditorium::create($mysqli, $data);

if (!$auditorium) {
    $response["status"] = 500;
    $response["message"] = "Failed to add auditorium";
    echo json_encode($response);
    return;
}

$response["message"] = "Auditorium added successfully";
echo json_encode($response);
