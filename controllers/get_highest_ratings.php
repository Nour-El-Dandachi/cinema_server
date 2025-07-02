<?php

require("../models/Movie.php");
require("../connection/connection.php");

$response = [];
$response["status"] = 200;


$sql = "
    SELECT *
    FROM movies
    ORDER BY CAST(rating AS DECIMAL(3,1)) DESC
    LIMIT 3;
";

$query = $mysqli->prepare($sql);

$query->execute();
$result = $query->get_result();

$movies= $result->fetch_assoc();

while ($row = $result->fetch_assoc()) {
    $response["movies"][] = $row;
}

echo json_encode($response);
