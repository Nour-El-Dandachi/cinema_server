<?php 

require(__DIR__ . "/../models/Seat.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ToArrayService.php");
require(__DIR__ . "/../services/ResponseService.php");

class SeatController{
    
    public function getAllSeats(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $seats = Seat::all($mysqli);
            $seats_array = ToArrayService::objectsToArray($seats); 
            echo ResponseService::success_response($seats_array);
            return;
        }

        $id = $_GET["id"];
        $seat = Seat::find($mysqli, $id);
        $seat_array= ToArrayService::objectsToArray([$seat]); 
        echo ResponseService::success_response($seat_array);
        return;
    }


    public function addSeat(){

        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !$data || 
            !isset($data["auditorium_id"]) ||
            !isset($data["seat_row"]) ||
            !isset($data["seat_number"]) ||
            !isset($data["seat_type"])
        ){
            echo ResponseService::failure_message("Missing required fields");
            return;
        }

        $seat = Seat::create($mysqli, $data);

        if(!$seat){
            echo ResponseService::failure_message("Failed to add Seat");
            return;
        }
        echo ResponseService::success_message("Seat added successfully");
    
    }

    public function getSeatsByAuditoriumId(){

        global $mysqli;
        $auditorium_id = $_GET["auditorium_id"] ?? null;
        if (!$auditorium_id){
            echo ResponseService::failure_message("Missing auditorium id");
            return;
        }

        
        $seats = Seat::findByAuditoriumId($mysqli, $auditorium_id);

        $updated = [];
        foreach ($seats as $s) {
            $updated[] = $s->toArray();
        }

        
        echo ResponseService::success_response($updated);
        return;
            
    }

    

}
