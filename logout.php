<?php
include 'db.php';
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    logActivity($username, 'logout'); 
    session_destroy();
}

header('Location: login.php');
exit();
?>
