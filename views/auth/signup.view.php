<?php require __DIR__ . '/../components/header.php'; ?>
<h1>Sign up</h1>
<a href="/login">Already have an account</a>

<form method="POST" action="/signup-submit">

<label>Username</label><br>
<input type="text" name="username" value='<?= $_POST['username'] ?? "" ?>'><br><br>

<label>E-Mail</label><br>
<input type="text" name="email" value='<?= $_POST['email'] ?? "" ?>'><br><br>

<label>Password</label><br>
<input type="password" name="password" value='<?= $_POST['password'] ?? "" ?>'><br><br>

<label>Confirm Password</label><br>
<input type="password" name="cpassword" value='<?= $_POST['cpassword'] ?? "" ?>'><br><br>

<button>Create Account</button>
</form>
<?php require __DIR__ . '/../components/footer.php'; ?>