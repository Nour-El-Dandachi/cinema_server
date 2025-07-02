<?php

require("../models/Seat.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);

if (
    !$data || 
    !isset($data["auditorium_id"]) ||
    !isset($data["seat_row"]) ||
    !isset($data["seat_number"]) ||
    !isset($data["seat_type"])
) {
    $response["status"] = 400;
    $response["message"] = "Missing required fields";
    echo json_encode($response);
    return;
}


$seat= Seat::create($mysqli, $data);

if (!$seat) {
    $response["status"] = 500;
    $response["message"] = "Failed to add seat";
    echo json_encode($response);
    return;
}

$response["message"] = "Seat added successfully";
echo json_encode($response);
