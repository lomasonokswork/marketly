<?php require __DIR__ . '/../components/header.php'; ?>

<div class="hero">
    <h1>Welcome to Marketly!</h1>
    <p>Your trusted marketplace for buying and selling quality items. Discover amazing deals, connect with sellers, and find exactly what you're looking for!</p>
</div><br>

<div class="cta-section">
    <p>Ready to get started? <a href="/signup" class="btn-primary">Create an account</a> to create your first Listing! or browse what others are selling below.</p>
<br>
</div>
<?php if (count($listings) == 0) { ?>
    <div class="empty-state">
        <p>No listings available yet. Be the first to <a href="create">post a listing</a> and start your marketplace journey!</p>
    </div>
<?php } else { ?>
<div class="listings-section">
    <h2>Latest Listings</h2>
    <ul class="listings-grid">
        <?php foreach ($listings as $listing) { ?>
            <li class="listing-item">
                <a href="show?id=<?= $listing["id"] ?>">
                    <span class="listing-title"><?= $listing["title"] ?></span>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>
<?php } ?>
<?php require __DIR__ . '/../components/footer.php'; ?>