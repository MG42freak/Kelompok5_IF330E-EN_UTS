<?php
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