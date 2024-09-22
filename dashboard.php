<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Ambil nama pengguna dari sesi
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Finalproject</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #007bff;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar-brand {
            font-size: 24px;
            color: white;
            text-decoration: none;
        }
        .hamburger {
            display: block;
            font-size: 30px;
            cursor: pointer;
            color: #fff;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #343a40;
            overflow-x: hidden;
            padding-top: 20px;
            transition: 0.3s;
            z-index: 1000;
        }
        .sidebar.show {
            left: 0;
        }
        .sidebar .profile {
            text-align: center;
            padding: 10px 0;
        }
        .sidebar .profile img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }
        .sidebar .profile h4 {
            color: #f2f2f2;
        }
        .sidebar a {
            padding: 10px 16px;
            text-decoration: none;
            font-size: 18px;
            color: #f2f2f2;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .content h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
        .welcome-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .welcome-card h3 {
            font-size: 28px;
            color: #007bff;
            margin-bottom: 15px;
            font-weight: bold;
            text-align: center;
        }
        .welcome-card p {
            color: #495057;
            font-size: 16px;
            line-height: 1.8;
            text-align: center;
        }
        .highlight {
            color: #007bff;
            font-weight: bold;
        }
        .section {
            margin-bottom: 30px;
        }
        .section form {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .logout {
            position: fixed;
            bottom: 20px;
            right: 20px;
            color: #fff;
            background-color: #dc3545;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .logout:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a class="navbar-brand" href="#">AES</a>
        <span class="hamburger" onclick="toggleSidebar()">&#9776;</span>
    </div>
    <div class="sidebar" id="sidebar">
        <div class="profile">
            <img src="profile.png" alt="Profile Image">
            <h4><?php echo htmlspecialchars($username); ?></h4>
        </div>
        <a href="dashboard.php?page=dashboard" onclick="closeSidebar()"><i class="fas fa-home"></i> Dashboard</a>
        <a href="dashboard.php?page=encrypt" onclick="closeSidebar()"><i class="fas fa-lock"></i> Encrypt</a>
        <a href="dashboard.php?page=decrypt" onclick="closeSidebar()"><i class="fas fa-unlock"></i> Decrypt</a>
        <a href="dashboard.php?page=activity" onclick="closeSidebar()"><i class="fas fa-list"></i> Activity Logs</a>
        <a href="logout.php" onclick="closeSidebar()"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <div class="content">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'encrypt':
                    include 'encrypt.php';
                    break;
                case 'decrypt':
                    include 'decrypt.php';
                    break;
                case 'activity':
                    include 'activity_log.php';
                    break;
                default:
                    echo "<h2>Dashboard</h2>
                          <div class='welcome-card'>
                              <h3>Digital Security Encryption and Decryption Application using AES-256 Algorithm</h3>
                              <p>This application uses the <span class='highlight'>AES (Advanced Encryption Standard)</span> algorithm with a <span class='highlight'>256-bit key length</span> to securely encrypt and decrypt files. It supports file formats such as PDF, DOCX, XLSX, JPEG, PNG, MP4, and ZIP, with a file size limit of up to 2 GB. On the dashboard, users can monitor recent activities, manage files, and access account information.</p>
                          </div>";
                    break;
            }
        } else {
            echo "<h2>Dashboard</h2>
                  <div class='welcome-card'>
                      <h3>Digital Security Encryption and Decryption Application using AES-256 Algorithm</h3>
                      <p>This application uses the <span class='highlight'>AES (Advanced Encryption Standard)</span> algorithm with a <span class='highlight'>256-bit key length</span> to securely encrypt and decrypt files. It supports file formats such as PDF, DOCX, XLSX, JPEG, PNG, MP4, and ZIP, with a file size limit of up to 2 GB. On the dashboard, users can monitor recent activities, manage files, and access account information.</p>
                  </div>";
        }
        ?>
    </div>
    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            var content = document.querySelector(".content");
            if (sidebar.classList.contains("show")) {
                sidebar.classList.remove("show");
                content.style.marginLeft = "0";
                localStorage.setItem('sidebar', 'hidden');
            } else {
                sidebar.classList.add("show");
                content.style.marginLeft = "250px";
                localStorage.setItem('sidebar', 'visible');
            }
        }

        // On page load, set the sidebar state based on localStorage
        document.addEventListener("DOMContentLoaded", function() {
            var sidebarState = localStorage.getItem('sidebar');
            var sidebar = document.getElementById("sidebar");
            var content = document.querySelector(".content");
            if (sidebarState === 'visible') {
                sidebar.classList.add("show");
                content.style.marginLeft = "250px";
            }
        });

        function closeSidebar() {
            var sidebar = document.getElementById("sidebar");
            var content = document.querySelector(".content");
            if (sidebar.classList.contains("show")) {
                sidebar.classList.remove("show");
                content.style.marginLeft = "0";
                localStorage.setItem('sidebar', 'hidden');
            }
        }
    </script>
</body>
</html>
