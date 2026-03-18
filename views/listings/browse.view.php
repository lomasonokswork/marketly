<?php require __DIR__ . '/../components/header.php'; ?>
<h1>Browse</h1>
<form>
    <input name='search_query' value='<?= $_GET["search_query"] ?? "" ?>' /> <button>Search</button>
</form>


<?php if (count($listings) == 0) { ?>
    <p>No listings found, try searching for something else!</p>
<?php } else { ?>
    <ul>
        <?php foreach ($listings as $listing) { ?>
            <li> <a href="show?id=<?= $listing["id"] ?>"> <?= htmlspecialchars($listing["title"]) . " by " . htmlspecialchars($listing["username"]) . " - $" . htmlspecialchars($listing["price"])?></a></li>
        <?php } ?>
    </ul>
<?php } ?>
<?php require __DIR__ . '/../components/footer.php'; ?>