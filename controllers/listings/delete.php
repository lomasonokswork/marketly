<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "DELETE FROM listings
            WHERE id = :id";
    $params = ["id" => $_POST["id"]];
    $db->query($sql, $params);
    header("Location: /");
    exit();
}
?>