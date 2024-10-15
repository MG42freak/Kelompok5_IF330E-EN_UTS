<?php
// process_register.php
require_once 'config.php';
require_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (register_user($name, $email, $password)) {
        header("Location: login.php");
    } else {
        echo "Registration failed. Please try again.";
    }
}

// process_login.php
require_once 'config.php';
require_once 'functions.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (login_user($email, $password)) {
        header("Location: dashboard.php");
    } else {
        echo "Invalid email or password. Please try again.";
    }
}
?>