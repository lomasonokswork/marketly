<?php require __DIR__ . '/../components/header.php'; ?>
<h1><?= htmlspecialchars($listing['title']) ?></h1>

<p><strong>Description:</strong> <?= htmlspecialchars($listing['description']) ?></p>
<p><strong>Price:</strong> $<?= htmlspecialchars($listing['price']) ?></p>
<p><strong>Status:</strong> <?= htmlspecialchars($listing['status']) ?></p>
<p><strong>Created:</strong> <?= htmlspecialchars($listing['created_at']) ?></p>

<?php require __DIR__ . '/../components/footer.php'; ?>