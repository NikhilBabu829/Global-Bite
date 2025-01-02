<?php
session_start();

function checkSessionExpiration($timeout = 900) { // Timeout in seconds (900 = 15 minutes)
    $timeout = 21600;
    if(isset($_SESSION['logged_in_time'])){
        $elapsedtime = time() - $_SESSION['logged_in_time'];
        if($elapsedtime > $timeout){
            session_unset();
            session_destroy();
            header('Location: ./frontend/src/pages/login.php');
            exit;
        }else{
            $_SESSION['logged_in_time'] = time();
        }
    }
    else{
        header("Location: ./frontend/src/pages/login.php");
        exit;
    }
}

// Call the function to check session expiration
checkSessionExpiration();
?>