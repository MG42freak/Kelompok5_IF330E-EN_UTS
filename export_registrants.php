<?php
// export_registrants.php
session_start();
require_once 'config.php';
require_once 'functions.php';

// Check if the event ID is provided
if (isset($_GET['id'])) {
    $conn = db_connect();
    $event_id = intval($_GET['id']);
    
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT u.name, u.email, r.registration_date 
                             FROM registrations r 
                             JOIN users u ON r.user_id = u.id 
                             WHERE r.event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
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
    
    // Close the file pointer and database connection
    fclose($output);
    $stmt->close();
    $conn->close();
    exit(); // Exit to ensure no further output is sent
} else {
    // Redirect if no event ID is provided
    header("Location: admin_dashboard_bg.php");
    exit();
}
