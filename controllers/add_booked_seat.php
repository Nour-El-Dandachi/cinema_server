<?php

require("../models/BookingSeat.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);

if (
    !$data || 
    !isset($data["booking_id"]) ||
    !isset($data["seat_id"]) ||
    !isset($data["price"])
) {
    $response["status"] = 400;
    $response["message"] = "Missing required fields";
    echo json_encode($response);
    return;
}


$booked_seat= BookingSeat::create($mysqli, $data);

if (!$booked_seat) {
    $response["status"] = 500;
    $response["message"] = "Failed to add booked seat";
    echo json_encode($response);
    return;
}

$response["message"] = "Booked seat added successfully";
echo json_encode($response);
