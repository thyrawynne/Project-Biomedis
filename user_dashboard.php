<?php
// Mulai sesi
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login
    header('Location: login.php');
    exit();
}

// Ambil informasi pengguna dari sesi
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username']; // Pastikan 'username' disimpan saat login
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - MEDIVA Hospital</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #0066cc;
            color: white;
        }

        .navbar .logo img {
            height: 40px;
        }

        .navbar .nav-links {
            display: flex;
            gap: 15px;
        }

        .navbar .nav-links a, .logout-btn {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .logout-btn {
            padding: 8px 12px;
            background-color: #ff4444;
            border-radius: 5px;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .dashboard-container h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        .dashboard-container p {
            color: #666;
            margin-bottom: 20px;
        }

        .dashboard-menu {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .dashboard-link {
            flex: 1 1 calc(33% - 20px);
            text-align: center;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f4f4f4;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s ease;
        }

        .dashboard-link:hover {
            background-color: #e6f7ff;
        }

        .dashboard-link img {
            height: 50px;
            margin-bottom: 10px;
        }

        .dashboard-link span {
            font-size: 16px;
            font-weight: bold;
        }

        footer {
            text-align: center;
            padding: 10px 20px;
            background-color: #333;
            color: white;
        }

        footer .footer-logo {
            height: 30px;
            margin-bottom: 10px;
        }

        footer ul {
            list-style: none;
            padding: 0;
            margin: 10px 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        footer ul li a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="index.php">
                    <img src="assets/logo.png" alt="MEDIVA Logo">
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="doctor.html">Dokter</a></li>
                <li><a href="layanan.html">Layanan</a></li>
            </ul>
            <a href="logout.php" class="logout-btn">Logout</a>
        </nav>
    </header>

    <div class="dashboard-container">
        <h1>Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h1>
        <p>Anda dapat mengakses fitur-fitur berikut dari dashboard:</p>

        <div class="dashboard-menu">
            <a href="profile.php" class="dashboard-link">
                <img src="assets/profile-icon.png" alt="Profil Saya">
                <span>Profil Saya</span>
            </a>
            <a href="appointments.php" class="dashboard-link">
                <img src="assets/appointments-icon.png" alt="Janji Temu">
                <span>Janji Temu</span>
            </a>
            <a href="services.php" class="dashboard-link">
                <img src="assets/services-icon.png" alt="Layanan">
                <span>Layanan</span>
            </a>
        </div>
    </div>

    <footer>
        <img src="assets/logo tanpa font.png" alt="MEDIVA Logo" class="footer-logo">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="doctor.html">Dokter</a></li>
            <li><a href="layanan.html">Layanan</a></li>
        </ul>
        <p>&copy; 2024 MEDIVA Hospital. All Rights Reserved.</p>
    </footer>
</body>
</html>
