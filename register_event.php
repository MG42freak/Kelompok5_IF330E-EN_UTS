<?php
// register_event.php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id'])) {
    $conn = db_connect();
    $user_id = $_SESSION['user_id'];
    $event_id = intval($_POST['event_id']);
    
    // Check if the event is still open and has available slots
    $sql_check = "SELECT status, max_participants, 
                  (SELECT COUNT(*) FROM registrations WHERE event_id = $event_id) as current_registrations 
                  FROM events WHERE id = $event_id";
    $result_check = $conn->query($sql_check);
    $event_check = $result_check->fetch_assoc();
    
    if ($event_check['status'] == 'open' && $event_check['current_registrations'] < $event_check['max_participants']) {
        $sql = "INSERT INTO registrations (user_id, event_id) VALUES ($user_id, $event_id)";
        if ($conn->query($sql) === TRUE) {
            header("Location: my_events.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, this event is no longer available for registration.";
    }
    
    $conn->close();
} else {
    header("Location: user_dashboard.php");
}
?>