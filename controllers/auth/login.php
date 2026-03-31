<?php

session_start();
require __DIR__ . "/../../Validator.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!Validator::string($username, min: 1, max: 255)) {
        $errors['username'] = 'Username is required.';
    }

    if (!Validator::string($password, min: 1, max: 255)) {
        $errors['password'] = 'Password is required.';
    }

    if (empty($errors)) {
        $sql = "SELECT id, username, password_hash FROM users WHERE username = :username LIMIT 1";
        $stmt = $db->query($sql, ["username" => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            header("Location: /");
            exit();
        }

        $errors['credentials'] = 'Wrong username or password.';
    }
}

$pageTitle = "Login";
$customStyles = "signup.css";

require __DIR__ . "/login_page.php";
