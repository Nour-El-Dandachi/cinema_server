<?php

require("../models/Showtime.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

if (!isset($_GET["id"])) {
    $response["status"] = 400;
    $response["message"] = "Missing showtime ID";
    echo json_encode($response);
    return;
}

$id = $_GET["id"];
$showtime = Showtime::find($mysqli, $id);

if (!$showtime) {
    $response["status"] = 404;
    $response["message"] = "Showtime not found";
    echo json_encode($response);
    return;
}

$showtime->delete($mysqli);

$response["message"] = "Showtime deleted successfully";
echo json_encode($response);

