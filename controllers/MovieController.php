<?php 

require(__DIR__ . "/../models/Movie.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ToArrayService.php");
require(__DIR__ . "/../services/ResponseService.php");

class MovieController{
    
    public function getAllMovies(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $movies = Movie::all($mysqli);
            $movies_array = ToArrayService::objectsToArray($movies); 
            echo ResponseService::success_response($movies_array);
            return;
        }

        $id = $_GET["id"];
        $movie = Movie::find($mysqli, $id);
        $movie_array= ToArrayService::objectsToArray([$movie]); 
        echo ResponseService::success_response($movie_array);
        return;
    }

    public function deleteMovies(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $deleting = Movie::deleteAll($mysqli);
            if(!$deleting){
                echo ResponseService::failure_message("Error in deleting movies");
                return;
            }

            echo ResponseService::success_response("Movies deleted successfully");
            return;
            
        }

        $id = $_GET["id"];
        $movie = Movie::find($mysqli, $id);

        if(!$movie){
            echo ResponseService::failure_message("Movie not found");
            return;
        }
        $movie->delete($mysqli);
        echo ResponseService::success_message("Movie deleted successfully");
        return;
    }

    public function updateMovie(){
        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data["id"])) {
            echo ResponseService::failure_message("Missing Movie ID");
            return;
        }

        $id = $data["id"];
        unset($data["id"]);

        $movie = Movie::find($mysqli, $id);
        if(!$movie){
            echo ResponseService::failure_message("Movie not found");
            return;
        }

        $updated = $movie->update($mysqli, $data);
        if(!$updated){
            echo ResponseService::failure_message("Failed to update movie");
            return; 
        }

        echo ResponseService::success_message("Movie updated successfully");
        
        
    }

    public function addMovie(){

        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || 
            !isset($data["title"]) || 
            !isset($data["description"]) || 
            !isset($data["genre"]) || 
            !isset($data["poster_url"]) ||
            !isset($data["release_date"]) ||
            !isset($data["duration_minutes"])
        ){
            echo ResponseService::failure_message("Missing required fields");
            return;
        }

        $movie = Movie::create($mysqli, $data);

        if(!$movie){
            echo ResponseService::failure_message("Failed to add movie");
            return;
        }
        echo ResponseService::success_message("Movie added successfully");
    
    }


}
