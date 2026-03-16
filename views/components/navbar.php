<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/browse">Browse Listings</a></li>
            <li><a href="/create">Create Listing</a></li>
            <li><a href="/login">Login</a></li>
        </ul>

        <?php if (!empty($_SESSION['username'])) : ?>
            <div class="navbar-user">Logged in as: <?= htmlspecialchars($_SESSION['username']) ?><a href="logout"><br>Logout</a></div>
        <?php endif; ?>
    </nav>
</header>
