<?php
    
    session_start();

    if(isset($_SESSION['user_id'])){
        setcookie(session_name(), '', time()-42000, '/');
        $_SESSION = array();
        session_destroy();
    }

    header("Location: /login");
    exit();
?>