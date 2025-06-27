<?php

require('../connection/connection.php');
require('Model.php');

class Showtime extends Model {
    private int $id;
    private int $movie_id;
    private int $auditorium_id;
    private string $start_time;
    private string $language;
    private bool $subtitled;
    private string $created_at;

    protected static string $table = "showtimes";

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->movie_id = $data["movie_id"];
        $this->auditorium_id = $data["auditorium_id"];
        $this->start_time = $data["start_time"];
        $this->language = $data["language"];
        $this->subtitled = (bool)$data["subtitled"];
        $this->created_at = $data["created_at"];
    }

    public function getId(): int { return $this->id; }
    public function getMovieId(): int { return $this->movie_id; }
    public function getAuditoriumId(): int { return $this->auditorium_id; }
    public function getStartTime(): string { return $this->start_time; }
    public function getLanguage(): string { return $this->language; }
    public function isSubtitled(): bool { return $this->subtitled; }
    public function getCreatedAt(): string { return $this->created_at; }

    public function setMovieId(int $movie_id) { $this->movie_id = $movie_id; }
    public function setAuditoriumId(int $auditorium_id) { $this->auditorium_id = $auditorium_id; }
    public function setStartTime(string $start_time) { $this->start_time = $start_time; }
    public function setLanguage(?string $language) { $this->language = $language; }
    public function setSubtitled(bool $subtitled) { $this->subtitled = $subtitled; }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "movie_id" => $this->movie_id,
            "auditorium_id" => $this->auditorium_id,
            "start_time" => $this->start_time,
            "language" => $this->language,
            "subtitled" => $this->subtitled,
            "created_at" => $this->created_at
        ];
    }

}
