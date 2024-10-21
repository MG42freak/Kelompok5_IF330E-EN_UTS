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

function login_user($email, $password) {
    $conn = db_connect();
    $email = sanitize_input($email);

    $stmt = $conn->prepare("SELECT id, name, password, is_admin FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            $stmt->close();
            $conn->close();
            return true;
        } else {
            error_log("Password mismatch for user: " . $email);
        }
    } else {
        error_log("User not found for email: " . $email);
    }
    
    $stmt->close();
    $conn->close();
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);
    
    if (!empty($email) && !empty($password)) {
        if (login_user($email, $password)) {
            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: user_dashboard.php");
                exit();
            }
        } else {
            echo "Invalid email or password. Please try again.";
        }
    } else {
        echo "Both email and password are required.";
    }
}