<?php

require("../models/Seat.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$auditorium_id = $_GET["auditorium_id"] ?? null;

if (!$auditorium_id) {
    $response["status"] = 400;
    $response["message"] = "Missing auditorium_id";
    echo json_encode($response);
    return;
}

$seats = Seat::findByAuditoriumId($mysqli, $auditorium_id);

if (!$seats) {
    $response["status"] = 404;
    $response["message"] = "No seats found";
    echo json_encode($response);
    return;
}

$updated = [];
foreach ($seats as $s) {
    $updated[] = $s->toArray();
}
$response["seats"] = $updated;

echo json_encode($response);
