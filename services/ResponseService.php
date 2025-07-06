<?php

class ResponseService {

    public static function success_response($payload){
        $response = [];
        $response["status"] = 200;
        $response["payload"] = $payload;
        return json_encode($response);
    }

    public static function failure_message($error){
        $response = [];
        $response["status"] = 404;
        $response["message"] = $error;
        return json_encode($response);
    }

    public static function success_message($message){
        $response = [];
        $response["status"] = 200;
        $response["message"] = $message;
        return json_encode($response);
    }


}