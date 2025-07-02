<?php

require("../models/User.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);


if (!$data || (!isset($data["email"]) && !isset($data["phone_number"])) || !isset($data["password"])) {
    $response["status"] = 400;
    $response["message"] = "Missing user required fields";
    echo json_encode($response);
    return;
}

$identifier = null;

if (isset($data["email"])) {
    $identifier = $data["email"];
} elseif (isset($data["phone_number"])) {
    $identifier = $data["phone_number"];
}

$user = User::findByEmailOrPhone($mysqli, $identifier);

if (!$user) {
    $response["status"] = 404;
    $response["message"] = "User not found";
    echo json_encode($response);
    return;
}

if (!password_verify($data["password"], $user->getPasswordHash())) {
    $response["status"] = 404;
    $response["message"] = "Incorrect password";
    echo json_encode($response);
    return;
}

$response["status"] = 200;
$response["message"] = "Login successful";
$response["user"] = $user->toArray();
echo json_encode($response);



