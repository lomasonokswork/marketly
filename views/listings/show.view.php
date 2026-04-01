<?php require __DIR__ . '/../components/header.php'; ?>
<h1><?= htmlspecialchars($listing['title']) ?></h1>

<?php if (!empty($images)): ?>
    <div style="margin-bottom: 2rem; max-width: 400px;">
        <h3>Images</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(80px, 1fr)); gap: 0.5rem;">
            <?php foreach ($images as $image): ?>
                <div style="overflow: hidden; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <img src="<?= htmlspecialchars($image['image_url']) ?>" alt="Listing image"
                        style="width: 100%; height: 80px; object-fit: cover; display: block;">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

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