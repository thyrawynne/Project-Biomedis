<?php
session_start();

// Koneksi ke database
$host = 'localhost';
$dbname = 'informatika_medis'; // Ganti dengan nama database Anda
$username = 'root';            // Ganti jika user MySQL berbeda
$password = '';                // Ganti jika ada password untuk user MySQL Anda

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Periksa login sebagai admin
    $stmtAdmin = $conn->prepare('SELECT * FROM admin WHERE username = :username');
    $stmtAdmin->bindParam(':username', $inputUsername);
    $stmtAdmin->execute();
    $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

    if ($admin && $admin['password'] === $inputPassword) {
        $_SESSION['admin_id'] = $admin['id_admin'];
        $_SESSION['username'] = $admin['username'];
        header('Location: admin_dashboard.php');
        exit();
    }

    // Periksa login sebagai user
    $stmtUser = $conn->prepare('SELECT * FROM user WHERE username = :username');
    $stmtUser->bindParam(':username', $inputUsername);
    $stmtUser->execute();
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['password'] === $inputPassword) {
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        header('Location: user_dashboard.php');
        exit();
    }

    // Jika login gagal
    $error = "Username atau password salah.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <form action="login.php" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        
        <button type="submit">Login</button>
        
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
