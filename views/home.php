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

    <header class="top-nav">
    <form method="get" action="/logout" style="margin: 0;">
        <input type="submit" value="Log out" class="nav-btn primary-btn">
    </form>
    </header>

    <!--  Ca idee, am vazut ca merge si metoda asta daca vrei, si e mai scurta, dar cu form e mai clar banuiesc. Da am vzt ca astea forms baga si un outline la buton, nush
     <header class="top-nav">
        <a href="/logout" class="nav-btn primary-btn">Log out</a>
     </header> -->

    <main class="info-section">
        <h1 class="info-title">Welcome, <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');?>!</h1>
        <p class="info-subtitle">Here you can view the accident map and traffic analysis.</p>
    </main>

</body>
</html>