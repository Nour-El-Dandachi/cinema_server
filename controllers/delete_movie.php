<?php

require("../models/Movie.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

if (!isset($_GET["id"])) {
    $response["status"] = 400;
    $response["message"] = "Missing movie ID";
    echo json_encode($response);
    return;
}

$id = $_GET["id"];
$movie = Movie::find($mysqli, $id);

if (!$movie) {
    $response["status"] = 404;
    $response["message"] = "Movie not found";
    echo json_encode($response);
    return;
}

$movie->delete($mysqli);

$response["message"] = "Movie deleted successfully";
echo json_encode($response);

