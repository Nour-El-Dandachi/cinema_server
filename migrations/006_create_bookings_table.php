<?php

require("../connection/connection.php");

$migration_name = '006_create_bookings_table';
$migration_sql = "SELECT * FROM migrations_log WHERE migration_name = ?";
$migration_query = $mysqli->prepare($migration_sql);
$migration_query->bind_param("s", $migration_name);
$migration_query->execute();
$result = $migration_query->get_result();

if ($result->num_rows > 0) {
    echo "Migration '$migration_name' already applied.";
    return;
}

$sql = "CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    showtime_id INT NOT NULL,
    total_price DECIMAL(10, 2),
    booking_status VARCHAR(50) DEFAULT 'confirmed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (showtime_id) REFERENCES showtimes(id) ON DELETE CASCADE
) ENGINE=InnoDB";

$query = $mysqli->prepare($sql);

if ($query) {
    if ($query->execute()) {
        echo "Bookings table created successfully. ";

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
