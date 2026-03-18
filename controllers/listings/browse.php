<?php
session_start();

$sql_query = "SELECT l.id, l.title, l.description, l.price, l.status, l.created_at, u.username, c.name as category_name FROM listings l 
    JOIN users u ON l.user_id = u.id 
    JOIN categories c ON l.category_id = c.id 
    WHERE l.status = 'Active'";
$params = [];

if (isset($_GET["search_query"]) && trim($_GET["search_query"]) != "") {
    $sql_query .= " AND l.title LIKE :search";
    $params["search"] = "%" . $_GET["search_query"] . "%";
}

$listings = $db->query($sql_query, $params)->fetchAll(PDO::FETCH_ASSOC);
$pageTitle = "Browse";
require "./views/listings/browse.view.php";