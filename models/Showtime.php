<?php

require('../connection/connection.php');
require('Model.php');

class Showtime extends Model {
    private int $id;
    private int $movie_id;
    private int $auditorium_id;
    private string $day;
    private string $time;
    private string $language;
    private int $subtitled;
    private string $created_at;

    protected static string $table = "showtimes";

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->movie_id = $data["movie_id"];
        $this->auditorium_id = $data["auditorium_id"];
        $this->day = $data["day"];
        $this->time = $data["time"];
        $this->language = $data["language"];
        $this->subtitled = $data["subtitled"];
        $this->created_at = $data["created_at"];
    }

    public function getId(): int { return $this->id; }
    public function getMovieId(): int { return $this->movie_id; }
    public function getAuditoriumId(): int { return $this->auditorium_id; }
    public function getDay(): string { return $this->day; }
    public function getTime(): string { return $this->time; }
    public function getLanguage(): string { return $this->language; }
    public function isSubtitled(): int { return $this->subtitled; }
    public function getCreatedAt(): string { return $this->created_at; }

    public function setMovieId(int $movie_id) { $this->movie_id = $movie_id; }
    public function setAuditoriumId(int $auditorium_id) { $this->auditorium_id = $auditorium_id; }
    public function setDay(string $day) { $this->day = $day; }
    public function setTime(string $time) { $this->time = $time; }
    public function setLanguage(?string $language) { $this->language = $language; }
    public function setSubtitled(int $subtitled) { $this->subtitled = $subtitled; }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "movie_id" => $this->movie_id,
            "auditorium_id" => $this->auditorium_id,
            "day" => $this->day,
            "time" => $this->time,
            "language" => $this->language,
            "subtitled" => $this->subtitled,
            "created_at" => $this->created_at
        ];
    }

    public static function findByDate(mysqli $mysqli, string $date): ?array {
        $sql = "SELECT * FROM showtimes WHERE day = ?";

        $query = $mysqli->prepare($sql);
        $query->bind_param("s", $date);

        $query->execute();
        $result = $query->get_result();

        $showtimes = [];
        while ($row = $result->fetch_assoc()) {
            $showtimes[] = new Showtime($row);
        }

        return $showtimes;
    }
}
