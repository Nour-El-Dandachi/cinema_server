<?php

require(__DIR__ . "/../connection/connection.php");
require('Model.php');

class BookingSeat extends Model {
    private int $id;
    private int $booking_id;
    private int $seat_id;
    private float $price;
    private string $created_at;

    protected static string $table = "booking_seats";

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->booking_id = $data["booking_id"];
        $this->seat_id = $data["seat_id"];
        $this->price = (float)$data["price"];
        $this->created_at = $data["created_at"];
    }

    public function getId(): int { return $this->id; }
    public function getBookingId(): int { return $this->booking_id; }
    public function getSeatId(): int { return $this->seat_id; }
    public function getPrice(): float { return $this->price; }
    public function getCreatedAt(): string { return $this->created_at; }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "booking_id" => $this->booking_id,
            "seat_id" => $this->seat_id,
            "price" => $this->price,
            "created_at" => $this->created_at
        ];
    }

    public static function getBookedSeatsByShowtime(mysqli $mysqli, int $showtime_id): ?array {
        $sql = "
            SELECT bs.seat_id
            FROM booking_seats bs
            INNER JOIN bookings b ON bs.booking_id = b.id
            WHERE b.showtime_id = ?
        ";

        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $showtime_id);

        $query->execute();
        $result = $query->get_result();

        $booked_seats = [];
        while ($row = $result->fetch_assoc()) {
            $booked_seats[] = $row["seat_id"];
        }

        $response["booked_seats"] = $booked_seats;

        return $booked_seats;
    }


}
