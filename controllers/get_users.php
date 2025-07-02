<?php

require("../models/User.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

try {
    if(!isset($_GET["id"])){
        $users = User::all($mysqli);

        $response["users"] = [];
        foreach($users as $u){
            $response["users"][] = $u->toArray();
        }
        echo json_encode($response);
        return;
    }

    $id = $_GET["id"];
    $user = User::find($mysqli, $id);
    if (!$user) {
        $response["status"] = 404;
        $response["message"] = "User not found";
        echo json_encode($response);
        return;
    }

    $response["users"] = $user->toArray();
    echo json_encode($response);

} catch (Exception $e) {
    $response["status"] = 500;
    $response["message"] = "Something went wrong";
    echo json_encode($response);
}
