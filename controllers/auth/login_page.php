<?php
session_start();

$pageTitle = "Login";
$customStyles = "login.css";

$errors = $errors ?? [];

require "./views/auth/login.view.php";