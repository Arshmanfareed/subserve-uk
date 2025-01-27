<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION["user"])) {
    // Unset or destroy the user session
    unset($_SESSION["user"]);
    // or use session_destroy() if you want to destroy the entire session

    // Redirect to the home page
    header("Location: index.php");
    exit();
} else {
    // If the user is not logged in, redirect to the home page
    header("Location: index.php");
    exit();
}
