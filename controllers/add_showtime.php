<?php

require("../models/Showtime.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);

if (
    !$data || 
    !isset($data["movie_id"]) ||
    !isset($data["auditorium_id"]) ||
    !isset($data["start_time"]) ||
    !isset($data["language"]) ||
    !isset($data["subtitled"])
) {
    $response["status"] = 400;
    $response["message"] = "Missing required fields";
    echo json_encode($response);
    return;
}


$showtime= Showtime::create($mysqli, $data);

if (!$showtime) {
    $response["status"] = 500;
    $response["message"] = "Failed to add showtime";
    echo json_encode($response);
    return;
}

$response["message"] = "Showtime added successfully";
echo json_encode($response);
