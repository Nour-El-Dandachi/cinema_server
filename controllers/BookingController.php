<?php 

require(__DIR__ . "/../models/Booking.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ToArrayService.php");
require(__DIR__ . "/../services/ResponseService.php");

class BookingController{
    
    public function getAllBookings(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $bookings = Booking::all($mysqli);
            $bookings_array = ToArrayService::objectsToArray($bookings); 
            echo ResponseService::success_response($bookings_array);
            return;
        }

        $id = $_GET["id"];
        $booking = Booking::find($mysqli, $id);
        $booking_array= ToArrayService::objectsToArray([$booking]); 
        echo ResponseService::success_response($booking_array);
        return;
    }


    public function addBooking(){

        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !$data || 
            !isset($data["user_id"]) ||
            !isset($data["showtime_id"]) ||
            !isset($data["total_price"]) ||
            !isset($data["booking_status"])
        ){
            echo ResponseService::failure_message("Missing required fields");
            return;
        }

        $booking = Booking::create($mysqli, $data);

        if(!$booking){
            echo ResponseService::failure_message("Failed to add booking");
            return;
        }
        
        $booking_id = $mysqli->insert_id;

        echo ResponseService::success_response([
            "booking_id" => $booking_id
        ]);
        }


}
