<?php
session_start();
$sql_query = "SELECT l.*, GROUP_CONCAT(i.image_url) as image_urls FROM listings l 
LEFT JOIN images i ON l.id = i.listing_id 
GROUP BY l.id
ORDER BY l.created_at DESC 
LIMIT 4";
$params = [];


$listings = $db->query($sql_query, $params)->fetchAll(PDO::FETCH_ASSOC);
$pageTitle = "Home";
$customStyles = "style.css";

require "./views/listings/index.view.php";