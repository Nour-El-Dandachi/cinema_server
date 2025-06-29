<?php

require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);
$showtime_id = $data["showtime_id"] ?? null;


if (!$showtime_id) {
    $response["status"] = 400;
    $response["message"] = "Missing showtime_id";
    echo json_encode($response);
    return;
}

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
echo json_encode($response);
