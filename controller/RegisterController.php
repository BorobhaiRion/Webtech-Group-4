<?php
require_once '../config/helpers.php';
require_once '../models/db.php';

$name = "";
$email = "";
$phone = "";
$password = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = validateInput($_POST["name"]);
    $email = validateInput($_POST["email"]);
    $phone = validateInput($_POST["phone"]);
    $password = $_POST["password"];



    
}
else{
        setFlash('error', implode("<br>", $errors));
        redirect('../views/register.php');
    }

?>