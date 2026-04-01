<?php require __DIR__ . '/../components/header.php'; ?>

<div class="hero">
    <h1>Welcome to Marketly!</h1>
    <p>Your trusted marketplace for buying and selling quality items. Discover amazing deals, connect with sellers, and
        find exactly what you're looking for!</p>
</div><br>

<div class="cta-section">
    <p>Ready to get started? <a href="/signup" class="btn-primary">Create an account</a> to create your first Listing!
        or browse what others are selling below.</p>
    <br>
</div>
<?php if (count($listings) == 0) { ?>
    <div class="empty-state">
        <p>No listings available yet. Be the first to <a href="create">post a listing</a> and start your marketplace
            journey!</p>
    </div>
<?php } else { ?>
    <div class="listings-section">
        <h2>Latest Listings</h2>
        <ul class="listings-grid" style="max-width: 600px;">
            <?php foreach ($listings as $listing) {
                $firstImage = null;
                if (!empty($listing['image_urls'])) {
                    $images = explode(',', $listing['image_urls']);
                    $firstImage = $images[0];
                }
                ?>
                <li class="listing-item">
                    <a href="show?id=<?= $listing["id"] ?>"
                        style="display: block; text-decoration: none; color: inherit; border-radius: 8px; overflow: hidden; background: #fff; border: 1px solid #e0e0e0; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: transform 0.2s, box-shadow 0.2s;">
                        <?php if ($firstImage): ?>
                            <div style="width: 100%; height: 100px; overflow: hidden;">
                                <img src="<?= htmlspecialchars($firstImage) ?>" alt="<?= htmlspecialchars($listing['title']) ?>"
                                    style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            </div>
                        <?php else: ?>
                            <div
                                style="width: 100%; height: 100px; background: #e8e8e8; display: flex; align-items: center; justify-content: center;">
                                <span style="color: #999;">No image</span>
                            </div>
                        <?php endif; ?>
                        <div style="padding: 0.75rem;">
                            <span class="listing-title"
                                style="font-weight: 600; font-size: 0.95rem;"><?= htmlspecialchars($listing["title"]) ?></span>
                        </div>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<?php require __DIR__ . '/../components/footer.php'; ?>