<?php

require("../connection/connection.php");

$response = [];
$response["status"] = 200;

$data = json_decode(file_get_contents("php://input"), true);

if (
    !$data || 
    !isset($data["movie_id"]) ||
    !isset($data["auditorium_id"])
) {
    $response["status"] = 400;
    $response["message"] = "Missing required fields";
    echo json_encode($response);
    return;
}

$movie_id= $data["movie_id"];
$auditorium_id= $data["auditorium_id"];

$sql= "
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

echo json_encode($response);