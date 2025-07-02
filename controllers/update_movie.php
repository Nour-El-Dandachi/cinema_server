<?php

require("../models/Movie.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data["id"])) {
    $response["status"] = 400;
    $response["message"] = "Missing movie ID";
    echo json_encode($response);
    return;
}

$id = $data["id"];
unset($data["id"]);

$movie = Movie::find($mysqli, $id);

if(!$movie){
    $response["status"] = 404;
    $response["message"] = "Movie not found";
    echo json_encode($response);
    return;
}

$updated = $movie->update($mysqli, $data);

if(!$updated){
    $response["status"] = 500;
    $response["message"] = "Failed to update movie";
    echo json_encode($response);
    return;
}

$response["message"] = "Movie updated successfully";
echo json_encode($response);