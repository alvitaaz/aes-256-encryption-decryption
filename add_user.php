<?php
// koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'secure_app_db');

// cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = 'alvita';
$password = 'admin'; 

// hash kata sandi
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// simpan pengguna dengan kata sandi yang telah di-hash
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $hashed_password);
$stmt->execute();

echo "Pengguna berhasil ditambahkan dengan kata sandi yang di-hash.";

$stmt->close();
$conn->close();
?>
