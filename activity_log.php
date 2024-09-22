<?php
include 'db.php'; 

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // untuk menghindari SQL Injection
    $stmt = $conn->prepare("SELECT * FROM activity_log WHERE username = ? ORDER BY timestamp DESC");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<div class='container'>";
    echo "<h3>Activity Log</h3>";

    if ($result->num_rows > 0) {
        echo "<table class='table table-striped'>";
        echo "<thead class='thead-custom'><tr><th>Timestamp</th><th>Username</th><th>Activity</th><th>Filename</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            $timestamp = htmlspecialchars($row['timestamp']) ?? 'N/A';
            $username = htmlspecialchars($row['username']) ?? 'N/A';
            $activity_description = htmlspecialchars($row['action']) ?? 'N/A';
            $filename = htmlspecialchars($row['filename']) ?? 'N/A'; // Tambahkan ini
            echo "<tr><td>{$timestamp}</td><td>{$username}</td><td>{$activity_description}</td><td>{$filename}</td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-info'>Tidak ada aktivitas yang ditemukan.</div>";
    }

    $stmt->close();
    echo "</div>";
} else {
    echo "<div class='alert alert-danger'>Anda harus login untuk melihat log aktivitas.</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #bbdefb; 
            color: #333; 
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #e3f2fd; 
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        h3 {
            margin-bottom: 30px;
            font-size: 28px;
            color: #007bff; 
        }
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            vertical-align: middle;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f1f8ff; 
        }
        .thead-custom {
            background-color: #007bff; 
            color: #ffffff; 
        }
        .thead-custom th {
            padding: 12px;
            text-align: center;
        }
        .alert {
            border-radius: 10px;
            margin-top: 20px;
        }
        .alert-info {
            background-color: #e3f2fd;
            color: #0288d1;
            border-color: #b3e5fc;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>

</body>
</html>
