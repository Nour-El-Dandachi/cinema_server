<?php 

require(__DIR__ . "/../models/user.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ToArrayService.php");
require(__DIR__ . "/../services/ResponseService.php");

class AuthController{
  

    public function login(){
        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);

        if (!$data || (!isset($data["email"]) && !isset($data["phone_number"])) || !isset($data["password"])) {
            echo ResponseService::failure_message("Missing required fields");
            return;
        }
        
        $identifier = null;

        if (isset($data["email"])) {
            $identifier = $data["email"];
        } elseif (isset($data["phone_number"])) {
            $identifier = $data["phone_number"];
        }

        $user = User::findByEmailOrPhone($mysqli, $identifier);

        if (!$user) {
            echo ResponseService::failure_message("User not found");
            return;
        }

        if (!password_verify($data["password"], $user->getPasswordHash())) {

            echo ResponseService::failure_message("Incorrect Password");
            return;
        }
        

        echo ResponseService::success_response($user->toArray());
        
        
    }

    public function register(){

        global $mysqli;

        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !$data || 
            !isset($data["email"]) || 
            !isset($data["phone_number"]) || 
            !isset($data["password_hash"]) || 
            !isset($data["full_name"])
        ) {
            echo ResponseService::failure_message("Missing required fields");
            return;
        }

        $data["password_hash"] = password_hash($data["password_hash"], PASSWORD_DEFAULT);

        $user = User::create($mysqli, $data);

        if (!$user) {
            echo ResponseService::failure_message("Failed to register user");
            return;
        }

        echo ResponseService::success_message("User registered successfully");
        
    }


}
