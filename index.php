<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <div class="mt-4">
            <a href="encrypt.php" class="btn btn-primary">Enkripsi File</a>
            <a href="decrypt.php" class="btn btn-secondary">Dekripsi File</a>
            <a href="profile.php" class="btn btn-info">Profil</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</body>
</html>
