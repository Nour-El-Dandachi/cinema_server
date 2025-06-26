<?php

require("../models/User.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

if (!isset($_GET["id"])) {
    $response["status"] = 400;
    $response["error"] = "Missing user ID";
    echo json_encode($response);
    return;
}

$id = $_GET["id"];
$user = User::find($mysqli, $id);

if (!$user) {
    $response["status"] = 404;
    $response["error"] = "User not found";
    echo json_encode($response);
    return;
}

$user->delete($mysqli);

$response["message"] = "User deleted successfully";
echo json_encode($response);

