<?php

require('../connection/connection.php');
require('Model.php');

class Seat extends Model {
    private int $id;
    private int $auditorium_id;
    private string $seat_row;
    private int $seat_number;
    private string $seat_type;
    private bool $booked;
    private string $created_at;

    protected static string $table = "seats";

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->auditorium_id = $data["auditorium_id"];
        $this->seat_row = $data["seat_row"];
        $this->seat_number = $data["seat_number"];
        $this->seat_type = $data["seat_type"];
        $this->booked = (bool)$data["booked"];
        $this->created_at = $data["created_at"];
    }

    public function getId(): int { return $this->id; }
    public function getAuditoriumId(): int { return $this->auditorium_id; }
    public function getSeatRow(): string { return $this->seat_row; }
    public function getSeatNumber(): int { return $this->seat_number; }
    public function getSeatType(): string { return $this->seat_type; }
    public function isBooked(): bool { return $this->booked; }
    public function getCreatedAt(): string { return $this->created_at; }

    public function setSeatRow(string $row) { $this->seat_row = $row; }
    public function setSeatNumber(int $number) { $this->seat_number = $number; }
    public function setSeatType(string $type) { $this->seat_type = $type; }
    public function setBooked(bool $booked) { $this->booked = $booked; }

    public function toArray(): array {
        return [
            $this->id,
            $this->auditorium_id,
            $this->seat_row,
            $this->seat_number,
            $this->seat_type,
            $this->booked,
            $this->created_at
        ];
    }
}
