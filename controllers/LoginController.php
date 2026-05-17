<?php
require_once '../config/helpers.php';
require_once '../models/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = validateInput($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $db = new db();
    $user = $db->getUserByEmail($email);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if ($remember) {
            $token = bin2hex(random_bytes(16));
            setcookie('remember_token', $token, time() + (86400 * 30), "/");
            // In a real app, save token to DB. For simplicity, we just set the cookie.
        }

        if ($user['role'] === 'admin') {
            redirect('../views/admin_dashboard.php');
        } else {
            redirect('../views/index.php');
        }
    } else {
        setFlash('error', "Invalid email or password");
        redirect('../views/login.php');
    }
}
?>
