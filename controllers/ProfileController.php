<?php
require_once '../config/helpers.php';
require_once '../models/db.php';

if (!isLoggedIn()) {
    redirect('../views/login.php');
}

$db = new db();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_profile') {
        $name = validateInput($_POST['name']);
        $email = validateInput($_POST['email']);
        $phone = validateInput($_POST['phone']);
        
        $address1 = validateInput($_POST['address1']);
        $address2 = validateInput($_POST['address2']);
        $addresses = json_encode([$address1, $address2]);

        if ($db->updateUserProfile($user_id, $name, $email, $phone, $addresses)) {
            setFlash('success', "Profile updated successfully");
            $_SESSION['name'] = $name;
        } else {
            setFlash('error', "Failed to update profile");
        }
    } 
    elseif ($action === 'change_password') {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        $user = $db->getUserById($user_id);
        if (password_verify($current_password, $user['password_hash'])) {
            if (strlen($new_password) >= 8 && $new_password === $confirm_password) {
                $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
                if ($db->updatePassword($user_id, $new_hash)) {
                    setFlash('success', "Password changed successfully");
                } else {
                    setFlash('error', "Failed to change password");
                }
            } else {
                setFlash('error', "New password must be at least 8 chars and match confirmation");
            }
        } else {
            setFlash('error', "Current password incorrect");
        }
    }
    
    redirect('../views/profile.php');
}
?>
