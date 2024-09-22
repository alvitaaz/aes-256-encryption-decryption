<?php

include 'db.php';


session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  
    $_SESSION['error'] = "Silakan login untuk mengakses halaman ini.";
    header("Location: login.php");
    exit;
}


?>
