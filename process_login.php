<?php
require_once 'config.php';
require_once 'functions.php';
require_once 'database.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);
    
    if (!empty($email) && !empty($password)) {
        if (login_user($email, $password)) {
            header("Location: dashboard.php");
            exit();
        }
        elseif ((isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == true)) {
            header("Location: admin_dashboard.php");
            exit();
        }
        else {
            echo "Invalid email or password. Please try again.";
        }
    } else {
        echo "Both email and password are required.";
    }
}

