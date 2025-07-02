<?php
require("../connection/connection.php");

$response = ["status" => 200];
$data = json_decode(file_get_contents("php://input"), true);

if (
  !$data ||
  !isset($data["movie_id"]) ||
  !isset($data["auditorium_id"]) ||
  !isset($data["date"]) ||
  !isset($data["time"])
) {
  $response["status"] = 400;
  $response["message"] = "Missing required fields";
  echo json_encode($response);
  return;
}

$movie_id = $data["movie_id"];
$auditorium_id = $data["auditorium_id"];
$date = $data["date"];
$time = $data["time"];

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

if ($row = $result->fetch_assoc()) {
  $response["showtime_id"] = $row["showtime_id"];
} else {
  $response["status"] = 404;
  $response["message"] = "Showtime not found";
}

echo json_encode($response);
