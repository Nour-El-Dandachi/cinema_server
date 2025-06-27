<?php

require("../connection/connection.php");

$migration_name = '004_create_showtimes_table';
$migration_sql = "SELECT * FROM migrations_log WHERE migration_name = ?";
$migration_query = $mysqli->prepare($migration_sql);
$migration_query->bind_param("s", $migration_name);
$migration_query->execute();
$result = $migration_query->get_result();

if ($result->num_rows > 0) {
    echo "Migration '$migration_name' already applied.";
    return;
}

$sql = "CREATE TABLE showtimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    auditorium_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    language VARCHAR(50),
    subtitled BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (auditorium_id) REFERENCES auditoriums(id) ON DELETE CASCADE
) ENGINE=InnoDB";

$query = $mysqli->prepare($sql);

if ($query) {
    if ($query->execute()) {
        echo "Showtimes table created successfully. ";

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
