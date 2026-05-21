<!DOCTYPE html>
<head>
    <title>Start</title>
    <link rel="icon" href="../favicon.ico">
</head>
<body>
    <h1>Welcome to Gridlock!</h1>
    <form method="POST" action="/start">
        <input type="hidden" name="action" value="login">
        <button type="submit">Login</button>
    </form>
    <form method="POST" action="/start">
        <input type="hidden" name="action" value="register">
        <button type="submit">Register</button>
    </form>
</body>