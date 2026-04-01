<?php require __DIR__ . '/../components/header.php'; ?>
<h1>Edit listing</h1>

<?php if (!empty($errors)): ?>
    <div class="errors" style="color: #b91c1c; margin-bottom: 1rem;">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="/edit?id=<?= htmlspecialchars($listing['id']) ?>" enctype="multipart/form-data">
    <label>Title</label>
    <input type="text" name="title" value='<?= htmlspecialchars($formData['title']) ?>'><br>

    <label>Description</label>
    <input type="text" name="description" value='<?= htmlspecialchars($formData['description']) ?>'><br>

    <label>Price (12.34)</label>
    <input type="number" name="price" value='<?= htmlspecialchars($formData['price']) ?>' step="0.01"><br>

    <label>Category</label>
    <select name="category_id">
        <option value="">-- Izvēlieties kategoriju --</option>
        <?php
        $selectedId = $formData['category_id'] ?? null;
        foreach ($categories as $category) {
            $sel = (isset($selectedId) && $selectedId == $category['id']) ? ' selected' : '';
            echo '<option value="' . htmlspecialchars($category['id']) . '"' . $sel . '>' . htmlspecialchars($category['name']) . '</option>';
        }
        ?>
    </select><br>

    <?php if (!empty($images)): ?>
        <div
            style="margin: 1.5rem 0; padding: 1.25rem; background: #f8f8f8; border-radius: 8px; border: 1px solid #e0e0e0;">
            <h3 style="margin-top: 0; margin-bottom: 0.75rem;">Current Images</h3>
            <p style="color: #666; margin-bottom: 1rem; font-size: 0.9rem;">Check the boxes below to delete images:</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 1rem;">
                <?php foreach ($images as $image): ?>
                    <div
                        style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <img src="<?= htmlspecialchars($image['image_url']) ?>" alt="Listing image"
                            style="width: 100%; height: 130px; object-fit: cover; display: block;">
                        <div style="padding: 0.75rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="checkbox" name="delete_images[]" value="<?= htmlspecialchars($image['id']) ?>"
                                    style="cursor: pointer;">
                                <span style="font-size: 0.85rem; color: #666;">Delete</span>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <label>Add More Images (JPG, PNG, GIF, WebP - Max 5MB each)</label>
    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/gif,image/webp"><br>

    <button>Atjaunināt</button>
</form>

<?php require __DIR__ . '/../components/footer.php'; ?>