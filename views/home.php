<!DOCTYPE html>
<body>
    <?php
        if(isset($_COOKIE["name"])){
            echo "Hello, " . htmlspecialchars($_COOKIE["name"]);
        }
        else {
            header("Location: ../views/AccountsView.php");
            exit();
        }
    ?>

    <form method="get" action="../controllers/logout.php">
        <input type="submit" value="Log out";>
    </form>
</body>
</html>