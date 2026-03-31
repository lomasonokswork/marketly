<?php
session_start();
require __DIR__ . "/../../Validator.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    http_response_code(404);
    require "controllers/404.php";
    die();
}

$sql = "SELECT * FROM listings WHERE id = :id LIMIT 1";
$listing = $db->query($sql, ['id' => $id])->fetch(PDO::FETCH_ASSOC);

if (!$listing) {
    http_response_code(404);
    require "controllers/404.php";
    die();
}

if ($listing['user_id'] != $_SESSION['user_id']) {
    http_response_code(403);
    require "controllers/404.php";
    die();
}

$errors = [];

$sql = "SELECT * FROM categories";
$params = [];
$categories = $db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = $_POST['price'] ?? '';
    $category_id = $_POST['category_id'] ?? '';

    if (!Validator::string($title, min: 1, max: 50)) {
        $errors['title'] = 'Title is required and must be 1-50 characters.';
    }

    if (!Validator::string($description, min: 1, max: 255)) {
        $errors['description'] = 'Description is required and must be 1-255 characters.';
    }

    if (!Validator::number($price, min: 0.01, max: 999999.99)) {
        $errors['price'] = 'Price must be a positive number up to 999999.99.';
    }

    if (empty($category_id) || !is_numeric($category_id)) {
        $errors['category_id'] = 'Please select a valid category.';
    } else {
        // Check if category exists
        $catCheck = $db->query("SELECT id FROM categories WHERE id = :id", ['id' => $category_id])->fetch(PDO::FETCH_ASSOC);
        if (!$catCheck) {
            $errors['category_id'] = 'Selected category does not exist.';
        }
    }

    if (empty($errors)) {
        $sql = "UPDATE listings SET title = :title, description = :description, price = :price, category_id = :category_id WHERE id = :id";
        $params = [
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'category_id' => $category_id,
            'id' => $id
        ];
        $db->query($sql, $params);

        header("Location: /show?id=" . $id);
        exit();
    }
}

$formData = [
    'title' => $_POST['title'] ?? $listing['title'],
    'description' => $_POST['description'] ?? $listing['description'],
    'price' => $_POST['price'] ?? $listing['price'],
    'category_id' => $_POST['category_id'] ?? $listing['category_id']
];

$pageTitle = "Edit Listing";
$customStyles = "style.css";

require "./views/listings/edit.view.php";