<?php
session_start(); // Start the session

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Optionally clear the session cookie (if sessions are using cookies)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Redirect to the login page or home page
header("Location: ../../frontend/src/pages/login.php?message=You have been logged out.");
exit;
