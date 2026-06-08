<?php
$bool = false;
if(isset($_SESSION['role'])){
    $bool = $_SESSION['role'] === 'admin';
}
$username = isset($_SESSION['user_id']) ? $_SESSION['username'] : "Error";

$current_page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>

<!DOCTYPE html>
<header class="top-nav">
        <a href="/home" class="nav-user" style="display: flex; align-items: center; justify-content: center;"><img src="/public/resources/gridlock.png" style="width:200px; height: 31px;"></a>
        
        <div class="nav-bar-div" style="width: 100%;">
        <div style="display: flex; gap: 10px" class="nav-buttons">
        <hr class="hide-on-mobile" style="margin-right: 10px;">
        <?php
            $location = '/map';
            $name = 'Map';
            $image = '/public/resources/location.png';
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
        <button id="themeToggleBtn" class="theme-toggle-btn">
           <img id="themeIcon" src="/public/resources/moon.png" alt="Toggle Theme">
        </button>
        <script>
          if (localStorage.getItem('theme') === 'light') {
          document.getElementById('themeIcon').src = '/public/resources/sun.png';
          }
        </script>
        </div>
        
        
        <div class="nav-button-container">
    <form method="post" action="/logout" style="display: inline-flex; margin: 0;">
        <button type="submit" style="cursor: pointer; background: none; border: none; padding: 0; display: inline-flex; align-items: center;">
            <img src="/public/resources/logout.png" style="max-width: 20px; max-height: 20px;">
            <span class="nav-text" style="white-space: nowrap;">Log out</span>
        </button>
    </form>
</div>
        </div>
        <script src="/public/js/theme.js"></script>
</header>