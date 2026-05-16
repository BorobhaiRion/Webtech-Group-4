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
    $errors = [];

    if (empty($name)){
        $errors[] = "Name is required";
    } 

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Invalid email format";
    } 
    
    if (strlen($password) < 8){
        $errors[] = "Password must be at least 8 characters";
    }

        

}
else{
        setFlash('error', implode("<br>", $errors));
        redirect('../views/register.php');
    }

?>