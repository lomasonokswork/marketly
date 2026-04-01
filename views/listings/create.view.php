<?php require __DIR__ . '/../components/header.php'; ?>
<h1>Create a listing</h1>

<?php if (!empty($errors)): ?>
    <div class="errors" style="color: #b91c1c; margin-bottom: 1rem;">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="/create" enctype="multipart/form-data">
    <label>Title</label>
    <input type="text" name="title" value='<?= $_POST['title'] ?? "" ?>'><br>

    <label>Description</label>
    <input type="text" name="description" value='<?= $_POST['description'] ?? "" ?>'><br>

    <label>Price (Example: xx.xx)</label>
    <input type="number" name="price" value='<?= $_POST['price'] ?? "" ?>' step="0.01"><br>

    <label>Category</label>
    <select name="category_id">
        <option value="">-- Izvēlieties kategoriju --</option>
        <?php
        $selectedId = $_POST['category_id'] ?? null;
        foreach ($categories as $category) {
            $sel = (isset($selectedId) && $selectedId == $category['id']) ? ' selected' : '';
            echo '<option value="' . $category['id'] . '"' . $sel . '>' . htmlspecialchars($category['name']) . '</option>';
        }
        ?>
    </select><br>

    <label>Images (JPG, PNG, GIF, WebP - Max 5MB each)</label>
    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/gif,image/webp"><br>

    <button>Izveidot</button>
</form>

<?php require __DIR__ . '/../components/footer.php'; ?>