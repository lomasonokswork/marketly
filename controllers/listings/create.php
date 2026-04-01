<?php
session_start();
require __DIR__ . "/../../Validator.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
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

    // Handle image uploads
    $uploadedImages = [];
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $uploadDir = __DIR__ . '/../../uploads/';
        $maxFileSize = 5 * 1024 * 1024; // 5MB
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            if (empty($tmpName)) {
                continue;
            }

            $fileName = $_FILES['images']['name'][$key];
            $fileSize = $_FILES['images']['size'][$key];
            $fileError = $_FILES['images']['error'][$key];
            $fileMime = mime_content_type($tmpName);

            // Validate file
            if ($fileError !== UPLOAD_ERR_OK) {
                $errors['images'] = 'Error uploading file: ' . $fileName;
                break;
            }

            if ($fileSize > $maxFileSize) {
                $errors['images'] = 'File ' . htmlspecialchars($fileName) . ' is too large. Max 5MB allowed.';
                break;
            }

            if (!in_array($fileMime, $allowedMimes)) {
                $errors['images'] = 'Invalid file type for ' . htmlspecialchars($fileName) . '. Only JPG, PNG, GIF, and WebP allowed.';
                break;
            }

            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($fileExt, $allowedExtensions)) {
                $errors['images'] = 'Invalid file extension for ' . htmlspecialchars($fileName);
                break;
            }

            // Generate unique filename
            $newFileName = uniqid('listing_', true) . '.' . $fileExt;
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($tmpName, $uploadPath)) {
                $uploadedImages[] = $newFileName;
            } else {
                $errors['images'] = 'Failed to save file: ' . htmlspecialchars($fileName);
                break;
            }
        }
    }

    if (empty($errors)) {
        $sql = "INSERT INTO listings (title, description, price, user_id, category_id, created_at, status) VALUES (:title, :description, :price, :user_id, :category_id, NOW(), 'Active')";
        $params = [
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'user_id' => $_SESSION['user_id'],
            'category_id' => $category_id
        ];
        $db->query($sql, $params);

        // Get the last inserted listing ID
        $listingId = $db->query("SELECT LAST_INSERT_ID() as id")->fetch(PDO::FETCH_ASSOC)['id'];

        // Insert uploaded images
        foreach ($uploadedImages as $imageName) {
            $imageSql = "INSERT INTO images (listing_id, image_url) VALUES (:listing_id, :image_url)";
            $imageParams = [
                'listing_id' => $listingId,
                'image_url' => '/uploads/' . $imageName
            ];
            $db->query($imageSql, $imageParams);
        }

        header("Location: /");
        exit();
    }
}

$pageTitle = "Create Listing";
$customStyles = "style.css";

require "./views/listings/create.view.php";
