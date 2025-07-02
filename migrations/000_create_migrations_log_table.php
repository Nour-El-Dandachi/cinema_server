<?php

require("../connection/connection.php");

$query = "CREATE TABLE IF NOT EXISTS migrations_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    migration_name VARCHAR(255) UNIQUE NOT NULL
)";

$execute = $mysqli->prepare($query);

if ($execute) {
    if ($execute->execute()) {
        echo "Migrations_log table created successfully.";
    } else {
        echo "Execution failed: " . $execute->error;
    }
} else {
    echo "Execution failed: " . $mysqli->error;
}
