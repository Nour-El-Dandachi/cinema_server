<?php

require("../models/User.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data["id"])) {
    $response["status"] = 400;
    $response["error"] = "Missing user ID";
    echo json_encode($response);
    return;
}

$id = $data["id"];
unset($data["id"]);

$user = User::find($mysqli, $id);

if (!$user) {
    $response["status"] = 404;
    $response["error"] = "User not found";
    echo json_encode($response);
    return;
}

$updated = $user->update($mysqli, $data);

if (!$updated) {
    $response["status"] = 500;
    $response["error"] = "Failed to update user";
    echo json_encode($response);
    return;
}

$response["message"] = "User updated successfully";
echo json_encode($response);
