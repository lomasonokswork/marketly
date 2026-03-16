<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $pageTitle ?? "Marketly" ?>
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <?php if (isset($customStyles)) { ?>
        <link rel="stylesheet" href="/css/<?= $customStyles ?>">
    <?php } else { ?>
        <link rel="stylesheet" href="/css/style.css">
    <?php } ?>
</head>

<body>
    <?php require "views/components/navbar.php"; ?>