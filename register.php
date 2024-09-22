<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Persiapkan dan eksekusi query untuk menyimpan data pengguna
    $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();

    // Tutup statement
    $stmt->close();

    // Redirect ke halaman login setelah pendaftaran berhasil
    header('Location: login.php');
    exit(); // Pastikan untuk berhenti eksekusi script setelah redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: url('backgroundd.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: rgba(135, 206, 250, 0.8); /* Sky blue with 80% transparency */
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: relative;
            overflow: hidden;
            min-height: 350px; /* Increased height */
        }

        .form-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.3));
            opacity: 0.6;
            pointer-events: none;
            transform: rotate(10deg);
            z-index: 1;
        }

        .form-container::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 30%, transparent 70%);
            opacity: 0.4;
            pointer-events: none;
            z-index: 1;
        }

        .form-container h2 {
            margin: 0 0 20px;
            padding: 0;
            color: #fff;
            font-size: 24px;
            position: relative;
            z-index: 2;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
        }

        .input-group i {
            position: absolute;
            top: 14px;
            left: 12px;
            color: #003366; /* Dark blue for icons */
        }

        .input-group input {
            width: calc(100% - 40px); /* Adjusted width to fit within the form */
            padding: 12px 12px 12px 40px;
            background: rgba(255, 255, 255, 0.9); /* Light white with some transparency */
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #333;
            font-size: 16px;
            outline: none;
            box-shadow: none;
            position: relative;
            z-index: 2;
        }

        .submit-btn {
            width: 80%; /* Shortened button width */
            background: linear-gradient(135deg, #003366, #004080); /* Darker blue gradient */
            border: none;
            padding: 15px;
            border-radius: 25px; /* Oval shape */
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 20px;
            position: relative;
            z-index: 2;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #004080, #003366); /* Darker blue gradient on hover */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <form action="register.php" method="post">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="submit-btn">Register</button>
        </form>
    </div>
</body>
</html>
