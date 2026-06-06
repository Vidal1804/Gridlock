<?php
$bool = false;
if(isset($_SESSION['role'])){
    $bool = $_SESSION['role'] === 'admin';
}
$username = isset($_SESSION['user_id']) ? $_SESSION['username'] : "Error";
?>

<!DOCTYPE html>
<header class="top-nav">
        <a href="/home" class="nav-user" style="display: flex; align-items: center; justify-content: center;"><img src="/public/resources/gridlock.png" style="width:200px; height: 31px;"></a>
        
        <div class="nav-bar-div" style="justify-content: space-between; width: 100%;">
        <div style="display: flex; gap: 10px">
        <hr class="hide-on-mobile">
        <?php
            $location = '/dashboard';
            $name = 'Dashboard';
            include "Button.php";
        ?>
        <?php
            $location = '/list';
            $name = 'List';
            include "Button.php";
        ?>
        <?php
            $location = '/profile';
            $name = htmlspecialchars($username, ENT_QUOTES, "UTF-8");
            include "Button.php";
        ?>
        <?php
        if($bool){
            $location = '/admin';
            $name = 'Admin';
            include 'Button.php';
        }
        ?>
        </div> 

        <form method="post" action="/logout" style="margin: 0; right: 0;">
            <input type="submit" value="Log out" class="nav-btn primary-btn">
        </form>
        </div>
        
</header>