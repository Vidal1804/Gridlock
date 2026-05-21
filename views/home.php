<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Error';

?>

<!DOCTYPE html>
<head>
    <title>Home</title>
    <link rel="icon" href="../favicon.ico">
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');?>!</h1>

    <form method="get" action="/logout">
        <input type="submit" value="Log out";>
    </form>
</body>
</html>