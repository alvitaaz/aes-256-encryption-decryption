<?php
include 'C:/xampp/htdocs/alvita/includes/aes.php';
include 'db.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file = $_FILES['file'];
    $key = $_POST['key'];
    $hmacKey = $_POST['hmac_key'];
    $username = $_SESSION['username']; 

    if ($file['error'] === UPLOAD_ERR_OK && !empty($key) && !empty($hmacKey)) {
        try {
            // Read the file in binary mode
            $fileContent = file_get_contents($file['tmp_name']);
            $decryptedData = aesDecrypt($fileContent, $key, $hmacKey);

            // Create a name for the decrypted file
            $decryptedFileName = 'uploads/' . 'decrypted_' . basename($file['name'], '.enc') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

            // Write the decrypted file to disk
            file_put_contents($decryptedFileName, $decryptedData);

            // Log decryption activity with the original file name
            logActivity($username, 'decryption', $file['name']);

            echo '<div class="alert alert-success">
                    File successfully decrypted. 
                    <a href="' . $decryptedFileName . '" class="btn btn-success btn-sm">
                        <i class="fas fa-download"></i> Download File
                    </a>
                  </div>';
        } catch (Exception $e) {
            echo '<div class="alert alert-danger">
                    An error occurred: ' . htmlspecialchars($e->getMessage()) . '
                  </div>';
        }
    } else {
        echo '<div class="alert alert-danger">
                There was a problem uploading the file or decryption keys were not provided.
              </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Decryption</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #bbdefb; /* Background color */
            color: #333; /* Main text color */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 40px;
            background-color: #e3f2fd; /* Form background */
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 30px;
            font-size: 32px;
            color: #007bff; /* Title text color */
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #ced4da; /* Input border color */
            background-color: #ffffff; /* Input background */
            color: #495057; /* Input text color */
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
            transition: border-color 0.3s, background-color 0.3s;
        }
        .form-control:focus {
            border-color: #007bff; /* Border color on focus */
            background-color: #ffffff; /* White background on focus */
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }
        .form-control[type="password"] {
            -webkit-text-security: disc; /* Hide text */
            text-security: disc;
        }
        .btn-primary {
            background-color: #007bff; /* Primary button color */
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-size: 16px;
            color: #ffffff; /* Button text color */
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Button color on hover */
        }
        .btn-success {
            background-color: #28a745; /* Success button color */
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-size: 16px;
            color: #ffffff; /* Button text color */
            transition: background-color 0.3s;
        }
        .btn-success:hover {
            background-color: #218838; 
        }
        .alert {
            border-radius: 10px;
            margin-top: 20px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        .alert a {
            color: #007bff;
            text-decoration: none;
        }
        .alert a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>File Decryption</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="file">Choose File:</label>
            <input type="file" name="file" id="file" class="form-control" required>
            <div id="fileSize" class="file-info"></div>
        </div>
        <div class="form-group">
            <label for="key">Enter Decryption Key:</label>
            <input type="password" name="key" id="key" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="hmac_key">Enter HMAC Key:</label>
            <input type="password" name="hmac_key" id="hmac_key" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Decrypt</button>
    </form>
</div>
<script>
    document.getElementById('file').addEventListener('change', function() {
        const fileInput = this;
        const fileSizeElement = document.getElementById('fileSize');
        
        if (fileInput.files.length > 0) {
            const fileSize = (fileInput.files[0].size / 1024).toFixed(2); // File size in KB
            fileSizeElement.textContent = `File size: ${fileSize} KB`;
        } else {
            fileSizeElement.textContent = '';
        }
    });
</script>
</body>
</html>
