<?php

require('../connection/connection.php');
require('Model.php');

class Snack extends Model {
    private int $id;
    private string $name;
    private float $price;
    private string $description;
    private string $created_at;

    protected static string $table = "snacks";

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->price = (float)$data["price"];
        $this->description = $data["description"];
        $this->created_at = $data["created_at"];
    }

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getPrice(): float { return $this->price; }
    public function getDescription(): string { return $this->description; }
    public function getCreatedAt(): string { return $this->created_at; }

    public function setName(string $name) { $this->name = $name; }
    public function setPrice(float $price) { $this->price = $price; }
    public function setDescription(string $desc) { $this->description = $desc; }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "price" => $this->price,
            "description" => $this->description,
            "created_at" => $this->created_at
        ];
    }

}
