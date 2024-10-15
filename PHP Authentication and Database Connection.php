<?php
// config.php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'event_registration_system');

// database.php
function db_connect() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// functions.php
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function register_user($name, $email, $password) {
    $conn = db_connect();
    $name = $conn->real_escape_string(sanitize_input($name));
    $email = $conn->real_escape_string(sanitize_input($email));
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
    $conn->close();
}

function login_user($email, $password) {
    $conn = db_connect();
    $email = $conn->real_escape_string(sanitize_input($email));
    
    $sql = "SELECT id, name, password, is_admin FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            return true;
        }
    }
    return false;
    $conn->close();
}

// logout.php
session_start();
session_destroy();
header("Location: index.php");
exit();