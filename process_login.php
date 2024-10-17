<?php
require_once 'config.php';
require_once 'functions.php';
require_once 'database.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);
    
    if (!empty($email) && !empty($password)) {
        // Assuming login_user returns true on successful login and sets user session
        if (login_user($email, $password)) {
            // Check if the user is an admin
            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: user_dashboard.php"); // Non-admin redirect
                exit();
            }
        } else {
            echo "Invalid email or password. Please try again.";
        }
    } else {
        echo "Both email and password are required.";
    }
}