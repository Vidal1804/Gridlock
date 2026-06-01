<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Error';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Gridlock</title>
    <link rel="icon" href="../favicon.ico">
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

<!-- Am schimbat aici in POST request ca sa fie secure-->
    <header class="top-nav">
    <form method="post" action="/logout" style="margin: 0;">
        <input type="submit" value="Log out" class="nav-btn primary-btn">
    </form>
    </header>


    <main class="info-section">
        <h1 class="info-title">Welcome, <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');?>!</h1>
        <p class="info-subtitle">Here you can view the accident map and traffic analysis.</p>
        <div style="margin-top: 20px; gap: 10px; display: flex">
            <a href="/dashboard"><button class="nav-btn primary-btn">Dashboard</button></a>
            <a href="/dashboard"><button class="nav-btn primary-btn">All Accidents</button></a>
        </div>
    </main>

</body>
</html>