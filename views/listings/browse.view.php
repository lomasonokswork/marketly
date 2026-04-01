<?php require __DIR__ . '/../components/header.php'; ?>
<h1>Browse</h1>

<form method="GET" style="margin-bottom: 1.5rem; padding: 1rem; background: #f5f5f5; border-radius: 4px;">
    <div style="margin-bottom: 1rem;">
        <label for="search"><strong>Search</strong></label><br>
        <input id="search" name='search_query' value='<?= htmlspecialchars($_GET["search_query"] ?? "") ?>'
            placeholder="Search listings..." style="width: 100%; padding: 0.5rem; margin-top: 0.5rem;" />
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
        <div>
            <label for="category"><strong>Category</strong></label><br>
            <select id="category" name="category" style="width: 100%; padding: 0.5rem; margin-top: 0.5rem;">
                <option value="">-- All Categories --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['id']) ?>" <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="sort"><strong>Sort by</strong></label><br>
            <select id="sort" name="sort" style="width: 100%; padding: 0.5rem; margin-top: 0.5rem;">
                <option value="newest" <?= ($_GET["sort"] ?? "newest") == "newest" ? 'selected' : '' ?>>Newest first
                </option>
                <option value="price_low" <?= ($_GET["sort"] ?? "") == "price_low" ? 'selected' : '' ?>>Price: Low to High
                </option>
                <option value="price_high" <?= ($_GET["sort"] ?? "") == "price_high" ? 'selected' : '' ?>>Price: High to
                    Low</option>
            </select>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
        <div>
            <label for="min_price"><strong>Min Price</strong></label><br>
            <input id="min_price" type="number" name="min_price"
                value='<?= htmlspecialchars($_GET["min_price"] ?? "") ?>' placeholder="0.00" step="0.01" min="0"
                style="width: 100%; padding: 0.5rem; margin-top: 0.5rem;" />
        </div>

        <div>
            <label for="max_price"><strong>Max Price</strong></label><br>
            <input id="max_price" type="number" name="max_price"
                value='<?= htmlspecialchars($_GET["max_price"] ?? "") ?>' placeholder="999999.99" step="0.01" min="0"
                style="width: 100%; padding: 0.5rem; margin-top: 0.5rem;" />
        </div>
    </div>

    <div style="display: flex; gap: 1rem;">
        <button type="submit"
            style="padding: 0.5rem 1rem; background: #0066cc; color: white; border: none; border-radius: 4px; cursor: pointer;">Apply
            Filters</button>
        <a href="/browse"
            style="padding: 0.5rem 1rem; background: #ccc; color: black; text-decoration: none; border-radius: 4px; align-self: center;">Clear
            Filters</a>
    </div>
</form>

<?php if (count($listings) == 0) { ?>
    <p>No listings found, try adjusting your filters!</p>
<?php } else { ?>
    <p style="margin-bottom: 1rem; color: #666;">Found <?= count($listings) ?>
        listing<?= count($listings) !== 1 ? 's' : '' ?></p>
    <ul
        style="list-style: none; padding: 0; display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.2rem;">
        <?php foreach ($listings as $listing) {
            $firstImage = null;
            if (!empty($listing['image_urls'])) {
                $images = explode(',', $listing['image_urls']);
                $firstImage = $images[0];
            }
            ?>
            <li
                style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <a href="show?id=<?= $listing["id"] ?>"
                    style="text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%;">
                    <?php if ($firstImage): ?>
                        <div style="width: 100%; height: 160px; overflow: hidden;">
                            <img src="<?= htmlspecialchars($firstImage) ?>" alt="<?= htmlspecialchars($listing['title']) ?>"
                                style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        </div>
                    <?php else: ?>
                        <div
                            style="width: 100%; height: 160px; background: #e8e8e8; display: flex; align-items: center; justify-content: center;">
                            <span style="color: #999; font-size: 0.9rem;">No image</span>
                        </div>
                    <?php endif; ?>
                    <div style="padding: 0.75rem; flex-grow: 1; display: flex; flex-direction: column;">
                        <strong
                            style="margin-bottom: 0.5rem; font-size: 0.95rem; line-height: 1.3;"><?= htmlspecialchars($listing["title"]) ?></strong>
                        <span style="color: #666; font-size: 0.8rem; margin-bottom: 0.5rem;">
                            <?= htmlspecialchars($listing["category_name"]) ?>
                        </span>
                        <span
                            style="font-size: 1rem; font-weight: bold; color: #0066cc; margin-top: auto;">$<?= number_format($listing["price"], 2) ?></span>
                    </div>
                </a>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
<?php require __DIR__ . '/../components/footer.php'; ?>