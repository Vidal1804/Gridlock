<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="icon" href="/public/resources/favicon.ico">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            
            <form method="post" action="/register">
                Name: <input type="text" name="username">
                Email: <input type="email" name="email">
                Password: <input type="password" name="password">
                Confirm Password: <input type="password" name="confirm_pass">
                <input type="submit" name="Submit" value="Sign up" class="nav-btn primary-btn full-width">
            </form>

            <a href="/start" class="back-link">Return</a>

            <?php if(isset($_GET['error'])) echo "<h3>" . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8') . "</h3>"; ?>
            
        </div>
    </div>

</body>
</html>