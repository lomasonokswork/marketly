<?php require __DIR__ . '/../components/header.php'; ?>
<h1>Login</h1>
<a href="/signup">Dont have an account?</a>

<?php if (!empty($errors)): ?>
    <div class="errors" style="color: #b91c1c; margin-bottom: 1rem;">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="/login-submit">

    <label>Username</label><br>
    <input type="text" name="username" value='<?= $_POST['username'] ?? "" ?>'><br><br>

    <label>Password</label><br>
    <input type="password" name="password"><br><br>

    <button>Login</button>
</form>
<?php require __DIR__ . '/../components/footer.php'; ?>