<?php
// event_details.php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = db_connect();

if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']);
    $sql = "SELECT * FROM events WHERE id = $event_id AND status = 'open'";
    $result = $conn->query($sql);
    $event = $result->fetch_assoc();

    // Check if user is already registered
    $user_id = $_SESSION['user_id'];
    $sql_check = "SELECT * FROM registrations WHERE user_id = $user_id AND event_id = $event_id";
    $result_check = $conn->query($sql_check);
    $is_registered = $result_check->num_rows > 0;
} else {
    header("Location: user_dashboard.php");
}

$conn->close();