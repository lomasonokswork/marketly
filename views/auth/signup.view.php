<?php require __DIR__ . '/../components/header.php'; ?>
<h1>Sign up</h1>
<a href="/login">Already have an account?</a>

<?php if (!empty($errors)): ?>
    <div style="color: red; margin: 10px 0;">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="/signup-submit">

    <label>Username</label><br>
    <input type="text" name="username" value='<?= htmlspecialchars($_POST['username'] ?? "") ?>'><br><br>

    <label>E-Mail</label><br>
    <input type="text" name="email" value='<?= htmlspecialchars($_POST['email'] ?? "") ?>'><br><br>

    <label>Password</label><br>
    <input type="password" name="password"><br><br>

    <label>Confirm Password</label><br>
    <input type="password" name="cpassword"><br><br>

    <button>Create Account</button>
</form>
<?php require __DIR__ . '/../components/footer.php'; ?>