<?php
require_once 'config.php';
require_once 'functions.php';
require_once 'database.php';


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