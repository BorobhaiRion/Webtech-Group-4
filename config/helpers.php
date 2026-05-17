<?php
session_start();

// Handle Remember Me session restoration
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    require_once __DIR__ . '/../models/db.php';
    $db = new db();
    $conn = $db->connection();
    $token = $conn->real_escape_string($_COOKIE['remember_token']);
    $res = $conn->query("SELECT * FROM users WHERE remember_token = '$token'");
    if ($res && $user = $res->fetch_assoc()) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
    }
    $conn->close();
}

function redirect($url) {
    header("Location: " . $url);
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function requireAdmin() {
    if (!isAdmin()) {
        redirect('login.php');
    }
}

function validateInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function setFlash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

function getFlash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    return null;
}
?>
