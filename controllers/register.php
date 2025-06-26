<?php

require("../models/User.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);

if (
    !$data || 
    !isset($data["email"]) || 
    !isset($data["phone_number"]) || 
    !isset($data["password_hash"]) || 
    !isset($data["full_name"])
) {
    $response["status"] = 400;
    $response["message"] = "Missing required fields";
    echo json_encode($response);
    return;
}

$data["password_hash"] = password_hash($data["password_hash"], PASSWORD_DEFAULT);

$created = User::create($mysqli, $data);

if (!$created) {
    $response["status"] = 500;
    $response["message"] = "Failed to register user";
    echo json_encode($response);
    return;
}

$response["message"] = "User registered successfully";
echo json_encode($response);
