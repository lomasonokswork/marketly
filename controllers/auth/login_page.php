<?php
session_start();

$pageTitle = "Login";
$customStyles = "signup.css";

$errors = $errors ?? [];

require "./views/auth/login.view.php";