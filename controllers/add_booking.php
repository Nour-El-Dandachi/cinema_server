<?php

require("../models/Booking.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);

if (
    !$data || 
    !isset($data["user_id"]) ||
    !isset($data["showtime_id"]) ||
    !isset($data["total_price"]) ||
    !isset($data["booking_status"])
) {
    $response["status"] = 400;
    $response["message"] = "Missing required fields";
    echo json_encode($response);
    return;
}


$booking= Booking::create($mysqli, $data);

if (!$booking) {
    $response["status"] = 500;
    $response["message"] = "Failed to add booking";
    echo json_encode($response);
    return;
}

$booking_id = $mysqli->insert_id;
$response["message"] = "Booking added successfully";
$response["booking_id"] = $booking_id;
echo json_encode($response);
