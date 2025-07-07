<?php 

require(__DIR__ . "/../models/BookingSeat.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ToArrayService.php");
require(__DIR__ . "/../services/ResponseService.php");

class BookedSeatController{
    
    public function getAllBookedSeats(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $seats = BookingSeat::all($mysqli);
            $seats_array = ToArrayService::objectsToArray($seats); 
            echo ResponseService::success_response($seats_array);
            return;
        }

        $id = $_GET["id"];
        $seat = BookingSeat::find($mysqli, $id);
        $seat_array= ToArrayService::objectsToArray([$seat]); 
        echo ResponseService::success_response($seat_array);
        return;
    }


    public function addBookedSeat(){

        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !$data || 
            !isset($data["booking_id"]) ||
            !isset($data["seat_id"]) ||
            !isset($data["price"])
        ){
            echo ResponseService::failure_message("Missing required fields");
            return;
        }

        $seat = BookingSeat::create($mysqli, $data);

        if(!$seat){
            echo ResponseService::failure_message("Failed to add Booked Seat");
            return;
        }
        echo ResponseService::success_message("Booked Seat added successfully");
    
    }


    public static function getBookedSeatsByShowtime(){
        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);
        $showtime_id = $data["showtime_id"] ?? null;


        if (!$showtime_id) {
            echo ResponseService::failure_message("Missing required fields");
            return;
        }

        $seats = BookingSeat::getBookedSeatsByShowtime($mysqli, $showtime_id);

        
        echo ResponseService::success_response($seats);
        return;
    }

}
