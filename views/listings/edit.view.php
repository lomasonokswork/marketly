<?php require __DIR__ . '/../components/header.php'; ?>
<h1>Edit listing</h1>

<?php if (!empty($errors)): ?>
    <div class="errors" style="color: #b91c1c; margin-bottom: 1rem;">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="/edit?id=<?= htmlspecialchars($listing['id']) ?>">
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
    </select>

    <button>Atjaunināt</button>
</form>

<?php require __DIR__ . '/../components/footer.php'; ?>