<?php
// Start or resume the session
session_start();

// Check if the user is logged in (you can customize this logic)
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}
?>
