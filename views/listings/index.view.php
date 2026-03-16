<?php require __DIR__ . '/../components/header.php'; ?>
<h1>Home</h1>


<?php if (count($listings) == 0) { ?>
    <p>No listings found, try searching for something else!</p>
<?php } else { ?>
    <ul>
        <?php foreach ($listings as $listing) { ?>
            <li> <a href="show?id=<?= $listing["id"] ?>"> <?= $listing["title"] ?> </a></li>
        <?php } ?>
    </ul>
<?php } ?>
<?php require __DIR__ . '/../components/footer.php'; ?>