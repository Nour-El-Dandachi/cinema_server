<?php

require(__DIR__ . "/../connection/connection.php");
require('Model.php');

class User extends Model{
    private int $id;
    private string $email;
    private string $phone_number;
    private string $password_hash;
    private string $full_name;
    private ?string $birthdate;
    private ?string $profile_image_url;
    private ?string $preferred_genres;
    private string $created_at;

    protected static string $table = "users";

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->email = $data["email"];
        $this->phone_number = $data["phone_number"];
        $this->password_hash = $data["password_hash"];
        $this->full_name = $data["full_name"];
        $this->birthdate = $data["birthdate"];
        $this->profile_image_url = $data["profile_image_url"];
        $this->preferred_genres = $data["preferred_genres"];
        $this->created_at = $data["created_at"];
    }

    public function getId(): int { return $this->id; }
    public function getEmail(): string{ return $this->email; }
    public function getPhoneNumber(): string { return $this->phone_number; }
    public function getPasswordHash(): string { return $this->password_hash; }
    public function getFullName(): string { return $this->full_name; }
    public function getBirthdate(): string { return $this->birthdate; }
    public function getProfileImageUrl(): string { return $this->profile_image_url; }
    public function getPreferredGenres(): string { return $this->preferred_genres; }
    public function getCreatedAt(): string { return $this->created_at; }


    public function setEmail($email) { $this->email = $email; }
    public function setPhoneNumber($phone) { $this->phone_number = $phone; }
    public function setPasswordHash($hash) { $this->password_hash = $hash; }
    public function setFullName($name) { $this->full_name = $name; }
    public function setBirthdate($date) { $this->birthdate = $date; }
    public function setProfileImageUrl($url) { $this->profile_image_url = $url; }
    public function setPreferredGenres($genres) { $this->preferred_genres = $genres; }


    public function toArray(): array {
        return [
            "id" => $this->id,
            "email" => $this->email,
            "phone_number" => $this->phone_number,
            "password_hash" => $this->password_hash,
            "full_name" => $this->full_name,
            "birthdate" => $this->birthdate,
            "profile_image_url" => $this->profile_image_url,
            "preferred_genres" => $this->preferred_genres,
            "created_at" => $this->created_at
        ];
}

    
    public static function findByEmailOrPhone(mysqli $mysqli, string $data){
        $sql = "SELECT * FROM users WHERE email = ? OR phone_number = ?";

        $query = $mysqli->prepare($sql);
        $query->bind_param("ss", $data, $data);

        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows === 0) return null;

        $user= $result->fetch_assoc();
        return new User($user);
    }

}
