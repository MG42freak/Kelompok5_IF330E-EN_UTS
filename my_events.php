<?php
// my_events.php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = db_connect();
$user_id = $_SESSION['user_id'];

$sql = "SELECT e.id, e.name, e.date, e.time, e.location, r.registration_date 
        FROM events e 
        JOIN registrations r ON e.id = r.event_id 
        WHERE r.user_id = $user_id";
$result = $conn->query($sql);

$conn->close();