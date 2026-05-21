<head>
    <title>Login</title>
    <link rel="icon" href="../favicon.ico">
</head>
<body style="display: flex; justify-content: center; align-items: center; margin: 0; min-height: 100vh; flex-direction: column;">
    
    <form style="display:flex; flex-direction: column; max-width: 300px; gap: 10px" 
          method="post" 
          action="../controllers/AccountsController.php">
        
        Name: <input type="text" name="username">
        Password: <input type="password" name="password">
        <input type="submit" name="Submit" value="Login">
    </form>

    <?php if(isset($_GET['error'])) echo "<h3>" . htmlspecialchars($_GET['error']) . "</h3>"; ?>
</body>