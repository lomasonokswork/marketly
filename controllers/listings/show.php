<?php
session_start();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    http_response_code(404);
    require "controllers/404.php";
    die();
}

$sql = "SELECT l.*, u.username, c.name as category_name FROM listings l 
    JOIN users u ON l.user_id = u.id 
    JOIN categories c ON l.category_id = c.id 
    WHERE l.id = :id LIMIT 1";
$listing = $db->query($sql, ['id' => $id])->fetch(PDO::FETCH_ASSOC);

if (!$listing) {
    http_response_code(404);
    require "controllers/404.php";
    die();
}

$pageTitle = htmlspecialchars($listing['title']);
$customStyles = "style.css";

require "./views/listings/show.view.php";
