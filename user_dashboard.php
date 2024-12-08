<?php
// Mulai sesi
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Ambil data pengguna dari database
$host = "localhost";
$username_db = "root"; // Sesuaikan dengan konfigurasi Anda
$password_db = ""; // Sesuaikan dengan konfigurasi Anda
$database = "informatika_medis";

$conn = new mysqli($host, $username_db, $password_db, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil informasi pengguna berdasarkan sesi
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Pengguna tidak ditemukan.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MEDIVA - Profil Pengguna</title>
  <link rel="stylesheet" href="pengguna.css">
</head>
<body>
  <div class="container">
    <header>
      <nav class="navbar">
        <div class="logo">
          <a href="index.html"><img src="assets/logo.png" alt="MEDIVA Logo"></a>
        </div>
        <ul class="nav-links">
          <li><a href="index.html">Home</a></li>
          <li><a href="berita.html">Berita</a></li>
          <li><a href="doctor.html">Dokter</a></li>
          <li><a href="layanan.html">Layanan</a></li>
          <li><a href="user_dashboard.php">Pengguna</a></li>
        </ul>
        <a href="logout.php" class="user-btn">Logout</a>
      </nav>
    </header>

    <section class="profile-section">
      <div class="profile-container">
        <div class="profile-image">
          <img src="assets/placeholder.png" alt="Foto Pengguna">
        </div>
        <div class="profile-info">
          <h2><?php echo htmlspecialchars($user['name']); ?></h2>
          <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
          <p>Nomor Telepon: <?php echo htmlspecialchars($user['phone']); ?></p>
          <p>Tanggal Lahir: <?php echo htmlspecialchars($user['birthdate']); ?></p>
          <button class="edit-btn">Edit Profil</button>
        </div>
      </div>
    </section>

    <section class="activity-section">
      <h2>Riwayat Aktivitas</h2>
      <table class="activity-table">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Aktivitas</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Ambil riwayat aktivitas pengguna
          $conn = new mysqli($host, $username_db, $password_db, $database);
          $query = "SELECT * FROM activities WHERE user_id = ? ORDER BY date DESC";
          $stmt = $conn->prepare($query);
          $stmt->bind_param("i", $user_id);
          $stmt->execute();
          $result = $stmt->get_result();

          while ($activity = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($activity['date']) . "</td>";
              echo "<td>" . htmlspecialchars($activity['activity']) . "</td>";
              echo "<td>" . htmlspecialchars($activity['status']) . "</td>";
              echo "</tr>";
          }

          $conn->close();
          ?>
        </tbody>
      </table>
    </section>

    <footer class="footer">
      <div class="footer-content">
        <img src="assets/logo tanpa font.png" alt="MEDIVA Logo" class="footer-logo">
        <ul class="footer-links">
          <li><a href="index.html">Home</a></li>
          <li><a href="berita.html">Berita</a></li>
          <li><a href="doctor.html">Dokter</a></li>
          <li><a href="layanan.html">Layanan</a></li>
        </ul>
        <p>Copyright 2024, MEDIVA Hospital</p>
      </div>
    </footer>
  </div>
</body>
</html>
