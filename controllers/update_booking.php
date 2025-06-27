<?php

require("../models/Booking.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data["id"])) {
    $response["status"] = 400;
    $response["message"] = "Missing booking ID";
    echo json_encode($response);
    return;
}

$id = $data["id"];
unset($data["id"]);

$booking = Booking::find($mysqli, $id);

if(!$booking){
    $response["status"] = 404;
    $response["message"] = "Booking not found";
    echo json_encode($response);
    return;
}

$updated = $booking->update($mysqli, $data);

if(!$updated){
    $response["status"] = 500;
    $response["message"] = "Failed to update booking";
    echo json_encode($response);
    return;
}

$response["message"] = "Booking updated successfully";
echo json_encode($response);