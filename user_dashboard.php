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
$query = "SELECT * FROM pasien WHERE id_pasien = ?"; // Menggunakan 'id_pasien' sesuai dengan 'pasien' di pengguna.php
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

// Tutup koneksi setelah mendapatkan data
$stmt->close();

// Mengambil riwayat aktivitas pengguna
$activityQuery = "SELECT * FROM riwayat_aktivitas WHERE id_pasien = ? ORDER BY tanggal DESC";
$activityStmt = $conn->prepare($activityQuery);
$activityStmt->bind_param("i", $user_id);
$activityStmt->execute();
$activityResult = $activityStmt->get_result();

// Tutup koneksi untuk aktivitas
$activityStmt->close();
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
          <a href="index.php"><img src="assets/logo.png" alt="MEDIVA Logo"></a>
        </div>
        <ul class="nav-links">
          <li><a href="index.php">Home</a></li>
          <li><a href="berita.php">Berita</a></li>
          <li><a href="doctor.php">Dokter</a></li>
          <li><a href="layanan.php">Layanan</a></li>
          <li><a href="user_dashboard.php" class="active">Pengguna</a></li>
        </ul>
        <a href="logout.php" class="user-btn">Logout</a>
      </nav>
    </header>

    <section class="profile-section">
      <div class="profile-container">
        <div class="profile-image">
          <!-- Menampilkan foto profil pengguna, jika ada -->
          <img src="assets/<?php echo !empty($user['foto']) ? $user['foto'] : 'placeholder.png'; ?>" alt="Foto Pengguna">
        </div>
        <div class="profile-info">
          <h2><?php echo htmlspecialchars($user['nama_pasien']); ?></h2>
          <p>Email: <?php echo htmlspecialchars($user['username']); ?></p>
          <p>Nomor Telepon: <?php echo htmlspecialchars($user['no_kontak_pasien']); ?></p>
          <p>Tanggal Lahir: <?php echo date('d M Y', strtotime($user['tgl_lahir'])); ?></p>
          
          <!-- Tombol Edit Profil mengarah ke edit_profile.php -->
          <button class="edit-btn">
            <a href="edit_profile.php?id=<?php echo $user['id_pasien']; ?>">Edit Profil</a>
          </button>
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
          // Menampilkan riwayat aktivitas pengguna
          if ($activityResult->num_rows > 0) {
              while($activity = $activityResult->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td>' . date('d M Y', strtotime($activity['tanggal'])) . '</td>';
                  echo '<td>' . htmlspecialchars($activity['aktivitas']) . '</td>';
                  echo '<td>' . htmlspecialchars($activity['status']) . '</td>';
                  echo '</tr>';
              }
          } else {
              echo "<tr><td colspan='3'>Tidak ada aktivitas.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </section>

    <footer class="footer">
      <div class="footer-content">
        <img src="assets/logo tanpa font.png" alt="MEDIVA Logo" class="footer-logo">
        <ul class="footer-links">
          <li><a href="index.php">Home</a></li>
          <li><a href="berita.php">Berita</a></li>
          <li><a href="doctor.php">Dokter</a></li>
          <li><a href="layanan.php">Layanan</a></li>
        </ul>
        <p>Copyright 2024, MEDIVA Hospital</p>
      </div>
    </footer>
  </div>
</body>
</html>
