<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<style>
  html, body {
    margin: 0;
    padding: 0;
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: #f8f5f2;
  }

  header {
    background: #385144;
    border-bottom: 1px solid rgba(215, 214, 214, 0.1);
    position: sticky;
    top: 0;
    z-index: 100;
  }

  nav {
    padding: 0 2rem;
    height: 68px;
    display: flex;
    align-items: center;
  }

  nav ul {
    list-style: none;
    width: 100%;
  }

  .topnav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
  }

  .topnav-left {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .topnav-right {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .topnav li {
    list-style: none;
  }

  .topnav li a {
    display: block;
    padding: 8px 16px;
    font-size: 15px;
    font-weight: 500;
    color: #ffffff;
    text-decoration: none;
    border-radius: 8px;
    transition: color 0.15s, background 0.15s;
    white-space: nowrap;
    letter-spacing: 0.1px;
  }

  .topnav li a:hover {
    color: #f8f5f8;
    background: rgba(0, 0, 0, 0.06);
  }

  .topnav li a.active {
    color: #2ca478;
    background: rgba(4, 170, 109, 0.1);
    font-weight: 600;
  }

  .topnav li a.btn-login {
    color: #ffffff;
    border: 1.5px solid #04aa6d;
    border-radius: 8px;
    font-weight: 500;
  }

  .topnav li a.btn-login:hover {
    border-color: #038a58;
    background: #038a58;
  }

  .topnav li a.btn-signup {
    color: #ffffff;
    background: rgba(0, 0, 0, 0.07);
    border-radius: 8px;
    font-weight: 600;
    font-size: 15px;
    padding: 8px 20px;
    border: 1.5px solid #04AA6D;
  }

  .topnav li a.btn-signup:hover {
    background: #038a58;
    border-color: #038a58;
  }
</style>

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