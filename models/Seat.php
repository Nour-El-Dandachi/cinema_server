<?php

require(__DIR__ . "/../connection/connection.php");
require('Model.php');

class Seat extends Model {
    private int $id;
    private int $auditorium_id;
    private string $seat_row;
    private int $seat_number;
    private string $seat_type;
    private string $created_at;

    protected static string $table = "seats";

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->auditorium_id = $data["auditorium_id"];
        $this->seat_row = $data["seat_row"];
        $this->seat_number = $data["seat_number"];
        $this->seat_type = $data["seat_type"];
        $this->created_at = $data["created_at"];
    }

    public function getId(): int { return $this->id; }
    public function getAuditoriumId(): int { return $this->auditorium_id; }
    public function getSeatRow(): string { return $this->seat_row; }
    public function getSeatNumber(): int { return $this->seat_number; }
    public function getSeatType(): string { return $this->seat_type; }
    public function getCreatedAt(): string { return $this->created_at; }

    public function setSeatRow(string $row) { $this->seat_row = $row; }
    public function setSeatNumber(int $number) { $this->seat_number = $number; }
    public function setSeatType(string $type) { $this->seat_type = $type; }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "auditorium_id" => $this->auditorium_id,
            "seat_row" => $this->seat_row,
            "seat_number" => $this->seat_number,
            "seat_type" => $this->seat_type,
            "created_at" => $this->created_at
        ];
    }

    public static function findByAuditoriumId(mysqli $mysqli, int $auditorium_id): ?array {
        $sql = "SELECT * FROM seats WHERE auditorium_id = ?";
        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $auditorium_id);
        $query->execute();
        $data = $query->get_result();

        $seats = [];
        while ($row = $data->fetch_assoc()) {
            $seats[] = new Seat($row);
        }

        return $seats;
    }

}
