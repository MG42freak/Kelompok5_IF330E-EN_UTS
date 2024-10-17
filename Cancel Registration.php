<?php
// cancel_registration.php
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
    
    $sql = "DELETE FROM registrations WHERE user_id = $user_id AND event_id = $event_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: my_events.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
} else {
    header("Location: user_dashboard.php");
}
?>