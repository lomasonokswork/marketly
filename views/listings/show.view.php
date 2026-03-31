<?php require __DIR__ . '/../components/header.php'; ?>
<h1><?= htmlspecialchars($listing['title']) ?></h1>

<p><strong>Description:</strong> <?= htmlspecialchars($listing['description']) ?></p>
<p><strong>Category:</strong> <?= htmlspecialchars($listing['category_name']) ?></p>
<p><strong>Price:</strong> $<?= htmlspecialchars($listing['price']) ?></p>
<p><strong>Status:</strong> <?= htmlspecialchars($listing['status']) ?></p>
<p><strong>Created:</strong> <?= htmlspecialchars($listing['created_at']) ?></p>

<br>
<?php
    if (isset($_SESSION['user_id'])) {
        if ($listing['user_id'] == $_SESSION['user_id']) { ?>
            <a href="edit?id=<?= $listing["id"] ?>">Edit</a>
            <form method="POST" action="/delete">
                <input name="id" value="<?= htmlspecialchars($listing["id"]) ?>" type="hidden" />
                <button>Delete</button>
            </form>
            <?php }
    }
?>

<?php require __DIR__ . '/../components/footer.php'; ?>