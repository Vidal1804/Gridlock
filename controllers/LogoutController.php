<?php
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        session_start();

        if(isset($_SESSION['user_id'])){
            setcookie(session_name(), '', time()-42000, '/');
            $_SESSION = array();
            session_destroy();
        }
        
        header("Location: /start");
        exit();
    }
    
?>