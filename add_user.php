<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'secure_app_db');

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Username dan password
$username = 'alvita';
$password = 'admin'; // Kata sandi yang ingin Anda gunakan

// Hash kata sandi
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Simpan pengguna dengan kata sandi yang telah di-hash
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $hashed_password);
$stmt->execute();

echo "Pengguna berhasil ditambahkan dengan kata sandi yang di-hash.";

$stmt->close();
$conn->close();
?>
