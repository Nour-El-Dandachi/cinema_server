<?php

require('../connection/connection.php');
require('Model.php');

class BookingSnack extends Model {
    private int $id;
    private int $booking_id;
    private int $snack_id;
    private int $quantity;
    private string $created_at;

    protected static string $table = "booking_snacks";

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->booking_id = $data["booking_id"];
        $this->snack_id = $data["snack_id"];
        $this->quantity = $data["quantity"];
        $this->created_at = $data["created_at"];
    }

    public function getId(): int { return $this->id; }
    public function getBookingId(): int { return $this->booking_id; }
    public function getSnackId(): int { return $this->snack_id; }
    public function getQuantity(): int { return $this->quantity; }
    public function getCreatedAt(): string { return $this->created_at; }

    public function toArray(): array {
        return [
            $this->id,
            $this->booking_id,
            $this->snack_id,
            $this->quantity,
            $this->created_at
        ];
    }
}
