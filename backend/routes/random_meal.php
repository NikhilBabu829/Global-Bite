<?php
session_start();
include './backend/helper/sessionCheck.php';

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in, redirect to the random meal page
    header("Location: ./fetch_random_meal.php");    
    exit;
} else {
    // User is not logged in, redirect to the login page
    header("Location: ../../frontend/src/pages/login.php");
    exit;
}
?>
