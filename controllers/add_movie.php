<?php

require("../models/Movie.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);

if (
    !$data || 
    !isset($data["title"]) || 
    !isset($data["description"]) || 
    !isset($data["genre"]) || 
    !isset($data["poster_url"]) ||
    !isset($data["release_date"]) ||
    !isset($data["duration_minutes"])
) {
    $response["status"] = 400;
    $response["message"] = "Missing required fields";
    echo json_encode($response);
    return;
}

$movie= Movie::create($mysqli, $data);

if (!$movie) {
    $response["status"] = 500;
    $response["message"] = "Failed to add movie";
    echo json_encode($response);
    return;
}

$response["message"] = "Movie added successfully";
echo json_encode($response);
