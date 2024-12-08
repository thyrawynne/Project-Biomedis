<?php
session_start();

// Periksa apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>
    <p>Ini adalah halaman dashboard admin.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
