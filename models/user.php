<?php

require_once '../connection/connection.php';

class User {
    private $user_id;
    private $email;
    private $phone_number;
    private $password_hash;
    private $full_name;
    private $birthdate;
    private $profile_image_url;
    private $preferred_genres;
    private $created_at;

    public function getUserId() { return $this->user_id; }
    public function getEmail() { return $this->email; }
    public function getPhoneNumber() { return $this->phone_number; }
    public function getPasswordHash() { return $this->password_hash; }
    public function getFullName() { return $this->full_name; }
    public function getBirthdate() { return $this->birthdate; }
    public function getProfileImageUrl() { return $this->profile_image_url; }
    public function getPreferredGenres() { return $this->preferred_genres; }
    public function getCreatedAt() { return $this->created_at; }


    public function setEmail($email) { $this->email = $email; }
    public function setPhoneNumber($phone) { $this->phone_number = $phone; }
    public function setPasswordHash($hash) { $this->password_hash = $hash; }
    public function setFullName($name) { $this->full_name = $name; }
    public function setBirthdate($date) { $this->birthdate = $date; }
    public function setProfileImageUrl($url) { $this->profile_image_url = $url; }
    public function setPreferredGenres($genres) { $this->preferred_genres = $genres; }


    public function __construct($row) {
        $this->user_id = $row['user_id'] ?? null;
        $this->email = $row['email'];
        $this->phone_number = $row['phone_number'];
        $this->password_hash = $row['password_hash'];
        $this->full_name = $row['full_name'];
        $this->birthdate = $row['birthdate'] ?? null;
        $this->profile_image_url = $row['profile_image_url'] ?? null;
        $this->preferred_genres = $row['preferred_genres'] ?? null;
        $this->created_at = $row['created_at'] ?? null;
    }

    
    public static function create($email, $phone, $password_hash, $full_name) {
        global $mysqli;
        $query = "INSERT INTO users (email, phone_number, password_hash, full_name)
                  VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ssss", $email, $phone, $password_hash, $full_name);
        return $stmt->execute();
    }

}
