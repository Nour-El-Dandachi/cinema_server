<?php

require("../models/Showtime.php");
require("../connection/connection.php");

$response = ["status" => 200];

$data = json_decode(file_get_contents("php://input"), true);

$date = $data["date"] ?? null;

if (!$date) {
    $response["status"] = 400;
    $response["message"] = "Missing date (YYYY-MM-DD)";
    echo json_encode($response);
    return;
}

$showtimes = Showtime::findByDate($mysqli, $date);

if (!$showtimes) {
    $response["status"] = 404;
    $response["message"] = "No showtimes found for this date";
    echo json_encode($response);
    return;
}

$updated = [];
foreach ($showtimes as $s) {
    $updated[] = $s->toArray();
}
$response["showtimes"] = $updated;

echo json_encode($response);
