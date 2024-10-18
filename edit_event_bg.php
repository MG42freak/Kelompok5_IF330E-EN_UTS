<?php
// edit_event.php
session_start();
require_once 'config.php';
require_once 'functions.php';

// Ensure the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

$conn = db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handling the form submission (POST request)
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string(sanitize_input($_POST['name']));
    $date = $conn->real_escape_string(sanitize_input($_POST['date']));
    $time = $conn->real_escape_string(sanitize_input($_POST['time']));
    $location = $conn->real_escape_string(sanitize_input($_POST['location']));
    $description = $conn->real_escape_string(sanitize_input($_POST['description']));
    $max_participants = intval($_POST['max_participants']);
    $status = $conn->real_escape_string(sanitize_input($_POST['status']));
    
    // Update the event in the database
    $sql = "UPDATE events SET name='$name', date='$date', time='$time', location='$location', 
            description='$description', max_participants=$max_participants, status='$status' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to the dashboard if update is successful
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // Handling the initial GET request to fetch the event's current details
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM events WHERE id=$id";
    $result = $conn->query($sql);
    $event = $result->fetch_assoc();
}

$conn->close();