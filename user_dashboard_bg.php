<?php
// user_dashboard.php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = db_connect();

// Fetch available events
$sql = "SELECT id, name, date, time, location FROM events WHERE status = 'open'";
$result = $conn->query($sql);

$conn->close();
?>