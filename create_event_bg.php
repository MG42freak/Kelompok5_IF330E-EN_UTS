<?php
// create_event.php
session_start();
require_once 'config.php';
require_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = db_connect();
    
    $name = $conn->real_escape_string(sanitize_input($_POST['name']));
    $date = $conn->real_escape_string(sanitize_input($_POST['date']));
    $time = $conn->real_escape_string(sanitize_input($_POST['time']));
    $location = $conn->real_escape_string(sanitize_input($_POST['location']));
    $description = $conn->real_escape_string(sanitize_input($_POST['description']));
    $max_participants = intval($_POST['max_participants']);
    
    $sql = "INSERT INTO events (name, date, time, location, description, max_participants) 
            VALUES ('$name', '$date', '$time', '$location', '$description', $max_participants)";
    
    if ($conn->query($sql) === TRUE) {
        $event_id = $conn->insert_id;
        
        // Handle image upload
        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . $event_id . "_" . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = $target_file;
                $sql = "UPDATE events SET image_url = '$image_url' WHERE id = $event_id";
                $conn->query($sql);
            }
        }
        
        header("Location: admin_dashboard_bg.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}