<?php

require("../models/Booking.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

if (!isset($_GET["id"])) {
    $response["status"] = 400;
    $response["message"] = "Missing booking ID";
    echo json_encode($response);
    return;
}

$id = $_GET["id"];
$booking = Booking::find($mysqli, $id);

if (!$booking) {
    $response["status"] = 404;
    $response["message"] = "Booking not found";
    echo json_encode($response);
    return;
}

$booking->delete($mysqli);

$response["message"] = "Booking deleted successfully";
echo json_encode($response);

