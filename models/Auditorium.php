<?php

require(__DIR__ . "/../connection/connection.php");
require('Model.php');

class Auditorium extends Model {
    private int $id;
    private string $name;
    private string $seat_layout;
    private string $created_at;

    protected static string $table = "auditoriums";

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->seat_layout = $data["seat_layout"];
        $this->created_at = $data["created_at"];
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getSeatLayout(): string { return $this->seat_layout; }
    public function getCreatedAt(): string { return $this->created_at; }

    public function setName(string $name) { $this->name = $name; }
    public function setSeatLayout(?string $layout) { $this->seat_layout = $layout; }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "seat_layout" => $this->seat_layout,
            "created_at" => $this->created_at,
        ];
    }

}
