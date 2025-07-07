<?php 

require(__DIR__ . "/../models/Showtime.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ToArrayService.php");
require(__DIR__ . "/../services/ResponseService.php");

class ShowtimeController{
    
    public function getAllShowtimes(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $showtimes = Showtime::all($mysqli);
            $showtimes_array = ToArrayService::objectsToArray($showtimes); 
            echo ResponseService::success_response($showtimes_array);
            return;
        }

        $id = $_GET["id"];
        $showtime = Showtime::find($mysqli, $id);
        $showtime_array= ToArrayService::objectsToArray([$showtime]); 
        echo ResponseService::success_response($showtime_array);
        return;
    }

    public function deleteShowtime(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $deleting = Showtime::deleteAll($mysqli);
            if(!$deleting){
                echo ResponseService::failure_message("Error in deleting showtimes");
                return;
            }

            echo ResponseService::success_response("Showtimes deleted successfully");
            return;
            
        }

        $id = $_GET["id"];
        $showtime = Showtime::find($mysqli, $id);

        if(!$showtime){
            echo ResponseService::failure_message("Showtime not found");
            return;
        }
        $showtime->delete($mysqli);
        echo ResponseService::success_message("Showtime deleted successfully");
        return;
    }


    public function addShowtime(){

        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !$data || 
            !isset($data["movie_id"]) ||
            !isset($data["auditorium_id"]) ||
            !isset($data["start_time"]) ||
            !isset($data["language"]) ||
            !isset($data["subtitled"])
        ){
            echo ResponseService::failure_message("Missing required fields");
            return;
        }

        $showtime = Showtime::create($mysqli, $data);

        if(!$showtime){
            echo ResponseService::failure_message("Failed to add showtime");
            return;
        }
        echo ResponseService::success_message("Showtime added successfully");
    
    }

    public function findShowtimesByMovieAndAuditorium(){
        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !$data || 
            !isset($data["movie_id"]) ||
            !isset($data["auditorium_id"])
        ) {
            echo ResponseService::failure_message("Missing required fields");
            return;
        }

        $movie_id= $data["movie_id"];
        $auditorium_id= $data["auditorium_id"];

        $showtimes= Showtime::findShowtimesByMovieAndAuditorium($mysqli, $movie_id, $auditorium_id);
        echo ResponseService::success_response($showtimes);
        return;

    }

    public function findShowtimeByDateAndTime(){
        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);

        if (
        !$data ||
        !isset($data["movie_id"]) ||
        !isset($data["auditorium_id"]) ||
        !isset($data["date"]) ||
        !isset($data["time"])
        ) {
        echo ResponseService::failure_message("Missing required fields");
            return;
        }

        $movie_id = $data["movie_id"];
        $auditorium_id = $data["auditorium_id"];
        $date = $data["date"];
        $time = $data["time"];

        $showtime = Showtime::findShowtimeId($mysqli, $movie_id, $auditorium_id, $date, $time);
        echo ResponseService::success_response($showtime);
        return;


    }


}
