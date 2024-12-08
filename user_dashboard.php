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
    <title>User Dashboard - Mediva Hospital</title>
    <link rel="stylesheet" href="styles.css">
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
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        <p>Ini adalah dashboard pengguna Anda. Anda dapat mengakses berbagai fitur berikut:</p>

        <div class="dashboard-menu">
            <a href="profile.php" class="dashboard-link">
                <img src="assets/profile-icon.png" alt="Profile">
                <span>Profil Saya</span>
            </a>
            <a href="appointments.php" class="dashboard-link">
                <img src="assets/appointments-icon.png" alt="Appointments">
                <span>Janji Temu</span>
            </a>
            <a href="services.php" class="dashboard-link">
                <img src="assets/services-icon.png" alt="Services">
                <span>Layanan</span>
            </a>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <img src="assets/logo tanpa font.png" alt="MEDIVA Logo" class="footer-logo">
            <ul class="footer-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="doctor.html">Dokter</a></li>
                <li><a href="layanan.html">Layanan</a></li>
            </ul>
            <p>&copy; 2024 MEDIVA Hospital. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
