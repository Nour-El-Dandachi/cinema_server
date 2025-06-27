<?php

require("../models/Booking.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;

try{
    if (!isset($_GET["id"])){
        $bookings= Booking::all($mysqli);

        if(!$bookings){
            $response["status"] = 404;
            $response["message"] = "No available bookings";
            echo json_encode($response);
            return;
        }

        $response["bookings"] = [];
        foreach($bookings as $b){
            $response["bookings"][] = $b->toArray();
        }
        echo json_encode($response);
        return;

    }

    $id= $_GET["id"];
    $booking= Booking::find($mysqli, $id);
    if(!$booking){
        $response["status"] = 404;
        $response["message"] = "Booking not found";
        echo json_encode($response);
        return;
    }

    $response["booking"] = $booking->toArray();
    echo json_encode($response);

} catch(Exception $e){
    $response["status"] = 500;
    $response["message"] = "Something went wrong";
    echo json_encode($response);
}