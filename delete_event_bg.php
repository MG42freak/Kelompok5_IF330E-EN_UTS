<?php
// delete_event.php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $conn = db_connect();
    $id = intval($_GET['id']);
    
    // Delete related registrations first
    $sql = "DELETE FROM registrations WHERE event_id = $id";
    $conn->query($sql);
    
    // Then delete the event
    $sql = "DELETE FROM events WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
    $conn->close();
} else {
    header("Location: admin_dashboard.php");
}
?>

<?php
// view_registrants.php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

$conn = db_connect();

if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']);
    $sql = "SELECT u.name, u.email, r.registration_date 
            FROM registrations r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.event_id = $event_id";
    $result = $conn->query($sql);
} else {
    header("Location: admin_dashboard.php");
}

$conn->close();
?>