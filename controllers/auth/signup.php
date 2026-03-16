<?php
session_start();

require __DIR__ . "/../../Validator.php";
if($_SERVER["REQUEST_METHOD"] == "POST") {

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$passwordconfirm = $_POST["cpassword"];

$errors = [];

if(!Validator::string($username, min: 6, max: 30)){
        $errors["username"] = "Username must be 6-30 characters long";
    }

if(!Validator::string($email, max: 255)){
        $errors["email"] = "Email must not exceed 255 characters";
    }

if(!Validator::string($password, min: 6, max: 30)){
        $errors["password"] = "Password must be 6-30 characters long";
    }

if($password !== $passwordconfirm) {
    $errors["passwordc"] = "Passwords do not match";
}

if(empty($errors)) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password_hash, created_at, permission_level)
        VALUES(:username, :email, :password_hash, NOW(), 1)";
    $params = ["username" => $username, "email" => $email, "password_hash" => $password_hash];
    $db->query($sql, $params);
    header("Location: /");
    exit();
}

}