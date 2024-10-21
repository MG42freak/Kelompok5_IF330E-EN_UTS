<?php
require_once 'config.php';
require_once 'database.php';

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function register_user($name, $email, $password) {
    $conn = db_connect();
    $name = sanitize_input($name);
    
    $email = filter_var(sanitize_input($email), FILTER_VALIDATE_EMAIL);
    if ($email === false) {
        return false;
    }
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        error_log("Error in registration: " . $stmt->error);
        $stmt->close();
        $conn->close();
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);
    
    if (!empty($name) && !empty($email) && !empty($password)) {
        if (register_user($name, $email, $password)) {
            header("Location: login.php");
            exit();
        } else {
            echo "Registration failed. Please try again.";
        }
    } else {
        echo "All fields are required.";
    }
}