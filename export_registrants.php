<?php
// export_registrants.php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $conn = db_connect();
    $event_id = intval($_GET['id']);
    
    $sql = "SELECT u.name, u.email, r.registration_date 
            FROM registrations r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.event_id = $event_id";
    $result = $conn->query($sql);
    
    // Output headers so that the file is downloaded rather than displayed
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=registrants.csv');
    
    // Create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');
    
    // Output the column headings
    fputcsv($output, array('Name', 'Email', 'Registration Date'));
    
    // Fetch the data from the database and output it
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
    
    $conn->close();
} else {
    header("Location: admin_dashboard.php");
}
?>