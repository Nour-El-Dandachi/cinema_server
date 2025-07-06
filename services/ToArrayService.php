<?php 

class ToArrayService {

    public static function objectsToArray($objects_db){
        $results = [];

        foreach($objects_db as $o){
             $results[] = $o->toArray();
        } 

        return $results;
    }

}