<?php
session_start();
$sql_query = "SELECT * FROM listings ORDER BY created_at DESC LIMIT 4";
$params = [];


$listings = $db->query($sql_query, $params)->fetchAll(PDO::FETCH_ASSOC);
$pageTitle = "Home";
$customStyles = "style.css";

require "./views/listings/index.view.php";