<?php
session_start();

// Clear session variables
session_unset();
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit;
?>
