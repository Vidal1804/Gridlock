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
        
        <div class="nav-bar-div" style="width: 100%;">
        <div style="display: flex; gap: 10px" class="nav-buttons">
        <hr class="hide-on-mobile" style="margin-right: 10px;">
        <?php
            $location = '/dashboard';
            $name = 'Dashboard';
            $image = '/public/resources/dashboard.png';
            include "Button.php";
        ?>
        <?php
            $location = '/list';
            $name = 'List';
            $image = '/public/resources/list.png';
            include "Button.php";
        ?>
        <?php
            $location = '/profile';
            $name = htmlspecialchars($username, ENT_QUOTES, "UTF-8");
            $image = '/public/resources/user.png';
            include "Button.php";
        ?>
        <?php
        if($bool){
            $location = '/admin';
            $name = 'Admin';
            $image = '/public/resources/admin.png';
            include 'Button.php';
        }
        ?>
        </div> 

        <a class="nav-button-container">
            <img src="/public/resources/logout.png" style="max-width: 20px; max-height: 20px">
            <form method="post" action="/logout" style="display: inline-flex; margin: 0; right: 0;">
                <input type="submit" class="nav-text" style="cursor: pointer;" value="Log out">
            </form>
        </a>
        </div>
        
</header>