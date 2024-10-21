<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'event_registration_system');

// Establish secure database connection with error handling
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Error handling for failed connections
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die("Database connection failed. Please try again later.");
}

// Set character encoding to prevent encoding issues
$conn->set_charset("utf8mb4");
?>