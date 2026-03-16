<?php
session_start();

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

$pageTitle = htmlspecialchars($listing['title']);
$customStyles = "style.css";

require "./views/listings/show.view.php";
