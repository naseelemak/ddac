<?php

session_start();

// remove all session variables
session_unset();

// destroy the session
session_destroy();

echo "<script>alert('Logout successful!');";
echo "window.location.href='login.php'</script>";

?>