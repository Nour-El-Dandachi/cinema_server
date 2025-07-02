<?php

require("../connection/connection.php");

$migration_name = '007_create_booking_seats_table';
$migration_sql = "SELECT * FROM migrations_log WHERE migration_name = ?";
$migration_query = $mysqli->prepare($migration_sql);
$migration_query->bind_param("s", $migration_name);
$migration_query->execute();
$result = $migration_query->get_result();

if ($result->num_rows > 0) {
    echo "Migration '$migration_name' already applied.";
    return;
}

$sql = "CREATE TABLE booking_seats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    seat_id INT NOT NULL,
    price DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    FOREIGN KEY (seat_id) REFERENCES seats(id) ON DELETE CASCADE
) ENGINE=InnoDB";


$query = $mysqli->prepare($sql);

if ($query) {
    if ($query->execute()) {
        echo "Booking seats table created successfully. ";

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
