<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="/public/resources/favicon.ico">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            
            <form method="post" action="/login">
                Name: <input type="text" name="username">
                Password: <input type="password" name="password">
                <input type="submit" name="Submit" value="Login" class="nav-btn primary-btn full-width">
            </form>

            <a href="/start" class="back-link">Return</a>

            <?php if(isset($_GET['error'])) echo "<h3>" . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8') . "</h3>"; ?>
            
        </div>
    </div>
    <?php include 'Footer.php' ?>
</body>
</html>