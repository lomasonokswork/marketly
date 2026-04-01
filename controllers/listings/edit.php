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

// Fetch existing images
$imagesSql = "SELECT * FROM images WHERE listing_id = :listing_id ORDER BY id ASC";
$images = $db->query($imagesSql, ['listing_id' => $id])->fetchAll(PDO::FETCH_ASSOC);

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

    // Handle image deletions
    if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
        $uploadDir = __DIR__ . '/../../uploads/';
        foreach ($_POST['delete_images'] as $imageId) {
            if (is_numeric($imageId)) {
                // Get the image file path
                $imageSql = "SELECT image_url FROM images WHERE id = :id AND listing_id = :listing_id LIMIT 1";
                $imageData = $db->query($imageSql, ['id' => $imageId, 'listing_id' => $id])->fetch(PDO::FETCH_ASSOC);

                if ($imageData) {
                    // Delete the file
                    $filePath = __DIR__ . '/../../' . ltrim($imageData['image_url'], '/');
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    // Delete database record
                    $db->query("DELETE FROM images WHERE id = :id", ['id' => $imageId]);
                }
            }
        }
    }

    // Handle new image uploads
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
        $sql = "UPDATE listings SET title = :title, description = :description, price = :price, category_id = :category_id WHERE id = :id";
        $params = [
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'category_id' => $category_id,
            'id' => $id
        ];
        $db->query($sql, $params);

        // Insert new images
        foreach ($uploadedImages as $imageName) {
            $imageSql = "INSERT INTO images (listing_id, image_url) VALUES (:listing_id, :image_url)";
            $imageParams = [
                'listing_id' => $id,
                'image_url' => '/uploads/' . $imageName
            ];
            $db->query($imageSql, $imageParams);
        }

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