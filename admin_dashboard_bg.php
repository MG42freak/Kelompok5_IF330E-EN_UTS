<?php
// admin_dashboard.php
session_start();
require_once 'config.php';
require_once 'functions.php';

// Check if user is admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

$conn = db_connect();

// Fetch available events
$sql = "SELECT id, name, date, time, location, max_participants, status FROM events";
$result = $conn->query($sql);

// Fetch number of registrants per event
$sql_registrants = "SELECT event_id, COUNT(*) as count FROM registrations GROUP BY event_id";
$result_registrants = $conn->query($sql_registrants);
$registrants = array();
while ($row = $result_registrants->fetch_assoc()) {
    $registrants[$row['event_id']] = $row['count'];
}

$conn->close();
?>