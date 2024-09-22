<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        logActivity($username, 'login'); 
        header('Location: dashboard.php');
        exit();
    } else {
        echo 'Login gagal. Username atau password salah.';
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
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
            padding: 20px;
            background: rgba(135, 206, 250, 0.8); /* Sky blue with 80% transparency */
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .form-container h2 {
            margin: 0 0 20px;
            padding: 0;
            color: #fff;
            font-size: 24px;
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
        }

        .submit-btn {
            width: 80%; /* Shortened button width */
            background: linear-gradient(135deg, #003366, #004080); /* Darker blue gradient */
            border: none;
            padding: 15px;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #004080, #003366); /* Darker blue gradient on hover */
        }

        .separator-container {
            margin: 20px 0;
            position: relative;
            text-align: center;
        }

        .separator-container::before {
            content: "";
            display: inline-block;
            width: 40%;
            height: 1px;
            background: #003366; /* Dark blue for the line */
            vertical-align: middle;
        }

        .separator-container::after {
            content: "";
            display: inline-block;
            width: 40%;
            height: 1px;
            background: #003366; /* Dark blue for the line */
            vertical-align: middle;
        }

        .separator-text {
            display: inline-block;
            padding: 0 10px;
            color: #003366; /* Dark blue for the text */
            font-size: 14px;
        }

        .extra-links {
            margin-top: 10px;
        }

        .extra-links button {
            width: 80%; /* Shortened button width */
            background: linear-gradient(135deg, #003366, #004080); /* Darker blue gradient */
            border: none;
            padding: 15px;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .extra-links button:hover {
            background: linear-gradient(135deg, #004080, #003366); /* Darker blue gradient on hover */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>User Login</h2>
        <form action="login.php" method="post">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="submit-btn">Login</button>
            
            <!-- Separator -->
            <div class="separator-container">
                <span class="separator-text"></span>
            </div>

            <div class="extra-links">
                <button type="button" onclick="window.location.href='register.php'">Register</button>
            </div>
        </form>
    </div>
</body>
</html>
