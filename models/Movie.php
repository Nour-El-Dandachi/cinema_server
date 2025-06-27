<?php

require('../connection/connection.php');
require('Model.php');

class Movie extends Model {
    private int $id;
    private string $title;
    private ?string $description;
    private ?string $genre;
    private ?string $rating;
    private ?string $actors;
    private ?string $trailer_url;
    private ?string $poster_url;
    private ?string $release_date;
    private ?int $duration_minutes;
    private string $created_at;

    protected static string $table = "movies";

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->title = $data["title"];
        $this->description = $data["description"];
        $this->genre = $data["genre"];
        $this->rating = $data["rating"];
        $this->actors = $data["actors"];
        $this->trailer_url = $data["trailer_url"];
        $this->poster_url = $data["poster_url"];
        $this->release_date = $data["release_date"];
        $this->duration_minutes = $data["duration_minutes"];
        $this->created_at = $data["created_at"];
    }

    public function getId(): int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getDescription(): string { return $this->description; }
    public function getGenre(): string { return $this->genre; }
    public function getRating(): string { return $this->rating; }
    public function getActors(): string { return $this->actors; }
    public function getTrailerUrl(): string { return $this->trailer_url; }
    public function getPosterUrl(): string { return $this->poster_url; }
    public function getReleaseDate(): string { return $this->release_date; }
    public function getDurationMinutes(): int { return $this->duration_minutes; }
    public function getCreatedAt(): string { return $this->created_at; }

    public function setTitle($title) { $this->title = $title; }
    public function setDescription($desc) { $this->description = $desc; }
    public function setGenre($genre) { $this->genre = $genre; }
    public function setRating($rating) { $this->rating = $rating; }
    public function setActors($actors) { $this->actors = $actors; }
    public function setTrailerUrl($url) { $this->trailer_url = $url; }
    public function setPosterUrl($url) { $this->poster_url = $url; }
    public function setReleaseDate($date) { $this->release_date = $date; }
    public function setDurationMinutes($min) { $this->duration_minutes = $min; }

    public function toArray() {
        return [
            $this->id,
            $this->title,
            $this->description,
            $this->genre,
            $this->rating,
            $this->actors,
            $this->trailer_url,
            $this->poster_url,
            $this->release_date,
            $this->duration_minutes,
            $this->created_at
        ];
    }
}
