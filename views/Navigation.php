<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Error';
?>

<!DOCTYPE html>
<header class="top-nav">
        <span class="nav-user">Welcome, <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');?>!</span>
        <form method="post" action="/logout" style="margin: 0;">
            <input type="submit" value="Log out" class="nav-btn primary-btn">
        </form>
</header>