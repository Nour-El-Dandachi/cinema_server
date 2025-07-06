<?php 

require(__DIR__ . "/../models/user.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ToArrayService.php");
require(__DIR__ . "/../services/ResponseService.php");

class UserController{

    public function deleteUser(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $deleting = User::deleteAll($mysqli);
            if(!$deleting){
                echo ResponseService::failure_message("Error in deleting users");
                return;
            }

            echo ResponseService::success_response("Users deleted successfully");
            return;
            
        }

        $id = $_GET["id"];
        $user = User::find($mysqli, $id);

        if(!$user){
            echo ResponseService::failure_message("User not found");
            return;
        }
        $user->delete($mysqli);
        echo ResponseService::success_message("User deleted successfully");
        return;
    }

    public function updateUser(){
        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || !isset($data["id"])) {
            echo ResponseService::failure_message("Missing user ID");
            return;
        }

        $id = $data["id"];
        unset($data["id"]);

        $user = User::find($mysqli, $id);
        if(!$user){
            echo ResponseService::failure_message("Movie not found");
            return;
        }

        $updated = $user->update($mysqli, $data);
        if(!$updated){
            echo ResponseService::failure_message("Failed to update user");
            return; 
        }

        echo ResponseService::success_message("User updated successfully");
        
        
    }

    
}
