<?php
// delete_event.php
session_start();
require_once 'config.php';
require_once 'functions.php';

// Ensure user is admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

// Check if 'id' parameter exists
if (isset($_GET['id'])) {
    $conn = db_connect();
    $id = intval($_GET['id']); // Event ID to delete
    
    // Step 1: Delete related registrations for the event
    $sql = "DELETE FROM registrations WHERE event_id = $id";
    $conn->query($sql);
    
    // Step 2: Delete the event itself
    $sql = "DELETE FROM events WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        // On success, redirect back to the events list
        header("Location: view_events.php?message=Event+deleted+successfully");
        exit();
    } else {
        echo "Error deleting event: " . $conn->error;
    }
    
    $conn->close();
} else {
    // If 'id' is not provided, redirect back to dashboard
    header("Location: admin_dashboard.php");
}
?>
