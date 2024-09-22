<?php
// Include file konfigurasi dan fungsi enkripsi/dekripsi
include 'config.php';

// Fungsi untuk mengenkripsi data menggunakan AES
function encryptData($data) {
    $key = AES_KEY;
    $iv = AES_IV;
    $method = AES_METHOD;
    $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
    return $encrypted;
}

// Fungsi untuk mendekripsi data menggunakan AES
function decryptData($encryptedData) {
    $key = AES_KEY;
    $iv = AES_IV;
    $method = AES_METHOD;
    $decrypted = openssl_decrypt($encryptedData, $method, $key, 0, $iv);
    return $decrypted;
}

// Proses data yang diterima dari POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'encrypt') {
        // Proses enkripsi
        $originalData = $_POST['originalData'];
        $encryptedData = encryptData($originalData);

        // Mengembalikan data yang terenkripsi
        echo json_encode(['encryptedData' => $encryptedData]);
        exit;
    } elseif (isset($_POST['action']) && $_POST['action'] == 'decrypt') {
        // Proses dekripsi
        $encryptedData = $_POST['encryptedData'];
        $decryptedData = decryptData($encryptedData);

        // Mengembalikan data yang didekripsi
        echo json_encode(['decryptedData' => $decryptedData]);
        exit;
    } else {
        // Jika tidak ada aksi yang sesuai
        echo json_encode(['error' => 'Invalid action']);
        exit;
    }
} else {
    // Jika tidak ada data POST
    echo json_encode(['error' => 'No data received']);
    exit;
}
?>
