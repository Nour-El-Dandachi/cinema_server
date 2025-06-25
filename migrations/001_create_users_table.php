<?php

require("../connection/connection.php");

$migrationName = '001_create_users_table';
$checkQuery = "SELECT * FROM migrations_log WHERE migration_name = ?";
$checkStmt = $mysqli->prepare($checkQuery);
$checkStmt->bind_param("s", $migrationName);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    echo "Migration '$migrationName' already applied.";
    exit;
}


$createQuery = "CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    birthdate DATE,
    profile_image_url TEXT,
    preferred_genres TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$createStmt = $mysqli->prepare($createQuery);

if ($createStmt) {
    if ($createStmt->execute()) {
        echo "Users table created successfully. ";

        $logQuery = "INSERT INTO migrations_log (migration_name) VALUES (?)";
        $logStmt = $mysqli->prepare($logQuery);
        $logStmt->bind_param("s", $migrationName);

        if ($logStmt->execute()) {
            echo "Migration '$migrationName' logged successfully.";
        } else {
            echo "Table created but failed to log migration: " . $logStmt->error;
        }

    } else {
        echo "Execution failed: " . $createStmt->error;
    }
} else {
    echo "Execution failed: " . $mysqli->error;
}
