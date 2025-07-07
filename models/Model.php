<?php 
abstract class Model{

    protected static string $table;
    protected static string $primary_key = "id";

    abstract public function getId(): int;

    public static function find(mysqli $mysqli, int $id){
        $sql= sprintf("SELECT * FROM %s WHERE %s = ?",
                       static::$table,
                       static::$primary_key);
        
        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $data = $query->get_result()->fetch_assoc();

        return $data ? new static($data) : null;
    }

    public static function all(mysqli $mysqli){
        $sql= sprintf("SELECT * FROM %s", static::$table);

        $query = $mysqli->prepare($sql);
        $query->execute();

        $data = $query->get_result();

        $objects = [];
        while($row = $data->fetch_assoc()){
            $objects[]= new static($row);
        }

        return $objects;
    }

    public static function where(mysqli $mysqli, $column, $data){
        $sql= sprintf("SELECT * FROM %s WHERE %s = ?",
                       static::$table,
                       $column);
        
        $type = "";
        if (is_int($data)) {
                $type = "i";
            } elseif (is_float($data)) {
                $type = "d";
            } elseif (is_null($data)) {
                $type = "s";
            } else {
                $type = "s";
            }
        

        $query = $mysqli->prepare($sql);
        $query->bind_param($type, $data);
        $query->execute();

        $data = $query->get_result();

        $objects = [];
        while($row = $data->fetch_assoc()){
            $objects[]= new static($row);
        }

        return $objects;
    }

    public static function create(mysqli $mysqli, array $data){
        $columns = array_keys($data);
        $placeholder = implode(", ", array_fill(0, count($columns), "?"));
        $columns_list = implode(", ", $columns);

        $sql = sprintf("INSERT INTO %s ($columns_list) VALUES ($placeholder)", static::$table);
        $query = $mysqli->prepare($sql);

        $types = "";
        foreach ($data as $value) {
            if (is_int($value)) {
                $types .= "i";
            } elseif (is_float($value)) {
                $types .= "d";
            } elseif (is_null($value)) {
                $types .= "s";
            } else {
                $types .= "s";
            }
        }

        $values = array_values($data);
        $query->bind_param($types, ...$values);

        return $query->execute();

    }

    public function delete(mysqli $mysqli){
        $sql = sprintf("DELETE FROM %s WHERE %s = ?", static::$table, static::$primary_key);

        $query = $mysqli->prepare($sql);

        $id = $this->getId();
        $query->bind_param("i", $id);

        $query->execute();
    }

    public static function deleteAll($mysqli){
        $sql = sprintf("DELETE FROM %s;", static::$table);

        $query = $mysqli->prepare($sql);

        return $query->execute();
    }

    public function update(mysqli $mysqli, array $data){

        $columns = array_keys($data);

        $set_parts = [];

        foreach ($columns as $c) {
            $set_parts[] = "$c = ?";
        }

        $set_query = implode(", ", $set_parts);

        $sql = sprintf("UPDATE %s SET $set_query WHERE %s = ?", static::$table, static::$primary_key);

        $query = $mysqli->prepare($sql);

        $types = "";
        foreach ($data as $value) {
            if (is_int($value)) {
                $types .= "i";
            } elseif (is_float($value)) {
                $types .= "d";
            } elseif (is_null($value)) {
                $types .= "s";
            } else {
                $types .= "s";
            }
        }

        $types .= "i";
        $values = array_values($data);
        $values[] = $this->getId();

        $query->bind_param($types, ...$values);
        
        return $query->execute();

    }
}
