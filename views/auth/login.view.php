<?php require __DIR__ . '/../components/header.php'; ?>
<h1>Login</h1>
<a href="/signup">Don't have an account?</a>

<?php if (!empty($errors)): ?>
    <div class="errors" style="color: #b91c1c; margin-bottom: 1rem;">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="/login-submit">
    <label>Username</label>
    <input type="text" name="username" value='<?= htmlspecialchars($_POST['username'] ?? "") ?>'>

    <label>Password</label>
    <input type="password" name="password">

    <button>Login</button>
</form>
<?php require __DIR__ . '/../components/footer.php'; ?>