<?php

require(__DIR__ . "/../connection/connection.php");
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

    public static function findShowtimesByMovieAndAuditorium(mysqli $mysqli, int $movie_id, int $auditorium_id): array {
        $sql = "
            SELECT day, time
            FROM showtimes
            WHERE movie_id = ?
            AND auditorium_id = ?
            AND day BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 6 DAY)
            ORDER BY day ASC, time ASC;
        ";

        $query = $mysqli->prepare($sql);
        $query->bind_param("ii", $movie_id, $auditorium_id);
        $query->execute();
        $result = $query->get_result();

        $dates = [];

        while ($row = $result->fetch_assoc()) {
            $date = $row["day"];
            $time = $row["time"];

            if (!isset($dates[$date])) {
                $dates[$date] = [];
            }

            $dates[$date][] = $time;
        }

        $response["dates"] = [];

        foreach ($dates as $date => $times) {
            $response["dates"][] = [
                "date" => $date,
                "times" => $times
            ];
        }

        return $response;
    }

    public static function findShowtimeId(
        mysqli $mysqli,
        int $movie_id,
        int $auditorium_id,
        string $date,
        string $time
    ): array {


        $sql = "
            SELECT id AS showtime_id
            FROM showtimes
            WHERE movie_id = ?
                AND auditorium_id = ?
                AND day = ?
                AND time = ?
            LIMIT 1
        ";

        $query = $mysqli->prepare($sql);
        $query->bind_param("iiss", $movie_id, $auditorium_id, $date, $time);
        $query->execute();
        $result = $query->get_result();

        $row = $result->fetch_assoc();

        $response["showtime_id"]= $row["showtime_id"];

        return $response;
        
    }

}
