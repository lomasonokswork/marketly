<?php
session_start();

$pageTitle = "Login";
$customStyles = "style.css";

$errors = $errors ?? [];

require "./views/auth/login.view.php";