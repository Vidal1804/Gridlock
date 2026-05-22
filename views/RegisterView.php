<!DOCTYPE html>
<head>
    <title>Register</title>
    <link rel="icon" href="../favicon.ico">
</head>
<body style="display: flex; justify-content: center; align-items: center; margin: 0; min-height: 100vh; flex-direction: column; gap: 10px">
    
    <form style="display:flex; flex-direction: column; max-width: 300px; gap: 10px" 
          method="post" 
          action="/register">
        
        Name: <input type="text" name="username">
        Email: <input type="text" name="email">
        Password: <input type="password" name="password">
        <input type="submit" name="Submit" value="Sign up">
    </form>

    <a href="/start" style="display: inline-block; padding: 8px 12px; background: #ccc; text-decoration: none; color: black; border-radius: 4px;">
    Return
    </a>

    <?php if(isset($_GET['error'])) echo "<h3>" . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8') . "</h3>"; ?>
</body>