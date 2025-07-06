<?php 

require(__DIR__ . "/../models/Auditorium.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ToArrayService.php");
require(__DIR__ . "/../services/ResponseService.php");

class AuditoriumController{
    
    public function getAllAuditoriums(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $auditoriums = Auditorium::all($mysqli);
            $auditoriums_array = ToArrayService::objectsToArray($auditoriums); 
            echo ResponseService::success_response($auditoriums_array);
            return;
        }

        $id = $_GET["id"];
        $auditorium = Auditorium::find($mysqli, $id);
        $auditorium_array= ToArrayService::objectsToArray($auditorium); 
        echo ResponseService::success_response($auditorium_array);
        return;
    }


    public function updateAuditorium(){
        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data["id"])) {
            echo ResponseService::failure_message("Missing Auditorium ID");
            return;
        }

        $id = $data["id"];
        unset($data["id"]);

        $auditorium = Auditorium::find($mysqli, $id);
        if(!$auditorium){
            echo ResponseService::failure_message("Auditorium not found");
            return;
        }

        $updated = $auditorium->update($mysqli, $data);
        if(!$updated){
            echo ResponseService::failure_message("Failed to update auditorium");
            return; 
        }

        echo ResponseService::success_message("Auditorium updated successfully");
        
        
    }

    public function addAuditorium(){

        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !$data || 
            !isset($data["name"]) ||
            !isset($data["seat_layout"])
        ){
            echo ResponseService::failure_message("Missing required fields");
            return;
        }

        $auditorium = Auditorium::create($mysqli, $data);

        if(!$auditorium){
            echo ResponseService::failure_message("Failed to add auditorium");
            return;
        }
        echo ResponseService::success_message("Auditorium added successfully");
    
    }


}
