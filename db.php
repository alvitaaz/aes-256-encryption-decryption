<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "secure_app_db";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/**
 * Mencatat aktivitas pengguna ke dalam log.
 *
 * @param string $username Nama pengguna yang melakukan aktivitas.
 * @param string $action Deskripsi aktivitas.
 * @param string $filename Nama file yang terkait dengan aktivitas (opsional).
 */
function logActivity($username, $action, $filename = 'N/A') {
    global $conn;

    // Menyiapkan pernyataan SQL untuk memasukkan data ke dalam tabel activity_log
    $stmt = $conn->prepare('INSERT INTO activity_log (username, action, filename, timestamp) VALUES (?, ?, ?, NOW())');
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Mengikat parameter dan mengeksekusi pernyataan
    $stmt->bind_param('sss', $username, $action, $filename);
    $stmt->execute();
    $stmt->close();
}
?>
