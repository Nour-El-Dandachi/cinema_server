<?php

require("../connection/connection.php");

$migration_name = '001_create_users_table';
$migration_sql = "SELECT * FROM migrations_log WHERE migration_name = ?";
$migration_query = $mysqli->prepare($migration_sql);
$migration_query->bind_param("s", $migration_name);
$migration_query->execute();
$result = $migration_query->get_result();

if ($result->num_rows > 0) {
    echo "Migration '$migration_name' already applied.";
    return;
}


$sql= "CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    birthdate DATE,
    profile_image_url TEXT,
    preferred_genres TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$query = $mysqli->prepare($sql);

if ($query) {
    if ($query->execute()) {
        echo "Users table created successfully. ";

        $log_sql = "INSERT INTO migrations_log (migration_name) VALUES (?)";
        $log_query = $mysqli->prepare($log_sql);
        $log_query->bind_param("s", $migration_name);

        if ($log_query->execute()) {
            echo "Migration '$migration_name' logged successfully.";
        } else {
            echo "Table created but failed to log migration: " . $log_query->error;
        }

    } else {
        echo "Execution failed: " . $query->error;
    }
} else {
    echo "Execution failed: " . $mysqli->error;
}
