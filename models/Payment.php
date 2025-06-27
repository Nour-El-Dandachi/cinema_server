<?php

require('../connection/connection.php');
require('Model.php');

class Payment extends Model {
    private int $id;
    private int $booking_id;
    private int $user_id;
    private float $amount;
    private string $payment_method;
    private string $payment_time;
    private string $created_at;

    protected static string $table = "payments";

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->booking_id = $data["booking_id"];
        $this->user_id = $data["user_id"];
        $this->amount = (float)$data["amount"];
        $this->payment_method = $data["payment_method"];
        $this->payment_time = $data["payment_time"];
        $this->created_at = $data["created_at"];
    }

    public function getId(): int { return $this->id; }
    public function getBookingId(): int { return $this->booking_id; }
    public function getUserId(): int { return $this->user_id; }
    public function getAmount(): float { return $this->amount; }
    public function getPaymentMethod(): string { return $this->payment_method; }
    public function getPaymentTime(): string { return $this->payment_time; }
    public function getCreatedAt(): string { return $this->created_at; }

    public function setAmount(float $amount) { $this->amount = $amount; }
    public function setPaymentMethod(string $method) { $this->payment_method = $method; }

    public function toArray(): array {
        return [
            $this->id,
            $this->booking_id,
            $this->user_id,
            $this->amount,
            $this->payment_method,
            $this->payment_time,
            $this->created_at
        ];
    }
}
