<?php
require_once '../config/helpers.php';
session_destroy();
setcookie('remember_token', '', time() - 3600, "/");
redirect('../views/login.php');
?>
