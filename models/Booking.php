<?php

require('../connection/connection.php');
require('Model.php');

class Booking extends Model {
    private int $id;
    private int $user_id;
    private int $showtime_id;
    private float $total_price;
    private string $booking_status;
    private string $created_at;

    protected static string $table = "bookings";

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->user_id = $data["user_id"];
        $this->showtime_id = $data["showtime_id"];
        $this->total_price = (float)$data["total_price"];
        $this->booking_status = $data["booking_status"];
        $this->created_at = $data["created_at"];
    }

    public function getId(): int { return $this->id; }
    public function getUserId(): int { return $this->user_id; }
    public function getShowtimeId(): int { return $this->showtime_id; }
    public function getTotalPrice(): float { return $this->total_price; }
    public function getBookingStatus(): string { return $this->booking_status; }
    public function getCreatedAt(): string { return $this->created_at; }

    public function setTotalPrice(float $price) { $this->total_price = $price; }
    public function setBookingStatus(string $status) { $this->booking_status = $status; }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "showtime_id" => $this->showtime_id,
            "total_price" => $this->total_price,
            "booking_status" => $this->booking_status,
            "created_at" => $this->created_at
        ];
    }

}
