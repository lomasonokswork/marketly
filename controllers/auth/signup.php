<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<header>
  <nav>
    <ul>
      <div class="topnav">
        <div class="topnav-left">
          <li><a href="/" class="active">Home</a></li>
          <li><a href="/browse">Browse Listings</a></li>
          <li><a href="/create">Create Listing</a></li>
        </div>
        <div class="topnav-right">
          <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id']): ?>
            <li>
              <a><?php echo "Logged in as: " . htmlspecialchars($_SESSION['username'] ?? 'User'); ?></a>
            </li>
            <li><a href="/logout" class="btn-login">Logout</a></li>
          <?php else: ?>
            <li><a href="/login" class="btn-login">Login</a></li>
            <li><a href="/signup" class="btn-signup">Sign Up</a></li>
          <?php endif; ?>
        </div>
      </div>
    </ul>
  </nav>
</header>