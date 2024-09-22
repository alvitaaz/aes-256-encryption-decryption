<?php
include 'config.php';

// Fungsi untuk mencatat aktivitas
function logActivity($username, $action) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO activity_logs (username, action) VALUES (?, ?)");
    $stmt->bind_param('ss', $username, $action);
    $stmt->execute();
    $stmt->close();
}
?>
