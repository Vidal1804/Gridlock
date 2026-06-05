<?php
$bool = false;
if(isset($_SESSION['role'])){
    $bool = $_SESSION['role'] === 'admin';
}
$username = isset($_SESSION['user_id']) ? $_SESSION['username'] : "Error";
?>

<!DOCTYPE html>
<header class="top-nav">
        <span class="nav-user">Gridlock</span>
        
        <div style="display: flex; gap: 10px">

        <a href="/dashboard"><button class="nav-btn primary-btn">Dashboard</button></a>
        <a href="/profile"><button class="nav-btn primary-btn"> <?php echo htmlspecialchars($username, ENT_QUOTES, "UTF-8"); ?> </button></a>
        <?php
        if($bool){
            include 'AdminButton.php';
        }
        ?>

        <hr>
        
        <form method="post" action="/logout" style="margin: 0;">
            <input type="submit" value="Log out" class="nav-btn primary-btn">
        </form>
    
        </div>
</header>