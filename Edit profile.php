<?php
// edit_profile.php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = db_connect();
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string(sanitize_input($_POST['name']));
    $email = $conn->real_escape_string(sanitize_input($_POST['email']));
    $password = $_POST['password'];
    
    $sql = "UPDATE users SET name = '$name', email = '$email'";
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql .= ", password = '$hashed_password'";
    }
    $sql .= " WHERE id = $user_id";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_name'] = $name;
        header("Location: user_dashboard.php");
    } else {
        echo "Error updating profile: " . $conn->error;
    }
} else {
    $sql = "SELECT name, email FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}

$conn->close();
?>