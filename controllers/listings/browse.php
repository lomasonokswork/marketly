<?php
session_start();

// Get all categories for filter
$categories = $db->query("SELECT * FROM categories ORDER BY name ASC", [])->fetchAll(PDO::FETCH_ASSOC);

// Build the base query
$sql_query = "SELECT l.id, l.title, l.description, l.price, l.status, l.created_at, u.username, c.name as category_name, GROUP_CONCAT(i.image_url) as image_urls FROM listings l 
    JOIN users u ON l.user_id = u.id 
    JOIN categories c ON l.category_id = c.id 
    LEFT JOIN images i ON l.id = i.listing_id
    WHERE l.status = 'Active'";
$params = [];

// Search filter
if (isset($_GET["search_query"]) && trim($_GET["search_query"]) != "") {
    $sql_query .= " AND l.title LIKE :search";
    $params["search"] = "%" . $_GET["search_query"] . "%";
}

// Category filter
if (isset($_GET["category"]) && is_numeric($_GET["category"]) && $_GET["category"] > 0) {
    $sql_query .= " AND l.category_id = :category";
    $params["category"] = $_GET["category"];
}

// Price range filter
$min_price = null;
$max_price = null;

if (isset($_GET["min_price"]) && trim($_GET["min_price"]) != "") {
    $min_price = floatval($_GET["min_price"]);
    if ($min_price >= 0) {
        $sql_query .= " AND l.price >= :min_price";
        $params["min_price"] = $min_price;
    }
}

if (isset($_GET["max_price"]) && trim($_GET["max_price"]) != "") {
    $max_price = floatval($_GET["max_price"]);
    if ($max_price >= 0) {
        $sql_query .= " AND l.price <= :max_price";
        $params["max_price"] = $max_price;
    }
}

// Sorting
$sort = $_GET["sort"] ?? "newest";
switch ($sort) {
    case "price_low":
        $sql_query .= " GROUP BY l.id ORDER BY l.price ASC";
        break;
    case "price_high":
        $sql_query .= " GROUP BY l.id ORDER BY l.price DESC";
        break;
    case "newest":
    default:
        $sql_query .= " GROUP BY l.id ORDER BY l.created_at DESC";
        break;
}

$listings = $db->query($sql_query, $params)->fetchAll(PDO::FETCH_ASSOC);
$pageTitle = "Browse";
require "./views/listings/browse.view.php";