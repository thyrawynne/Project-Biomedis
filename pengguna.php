<?php
// Menghubungkan ke database
$host = 'localhost';
$username = 'root'; // Nama pengguna database
$password = ''; // Password database
$dbname = 'informatika_medis'; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mulai sesi
session_start();

// Pastikan ID pengguna ada dalam sesi
if (!isset($_SESSION['user_id'])) {
    echo "Silakan login terlebih dahulu.";
    exit;
}

$user_id = $_SESSION['user_id']; // ID pengguna yang login

// Mengambil data profil pengguna dengan prepared statement
$sql_user = $conn->prepare("SELECT * FROM pasien WHERE id_pasien = ?");
$sql_user->bind_param("i", $user_id);
$sql_user->execute();
$result_user = $sql_user->get_result();

// Mengambil riwayat aktivitas pengguna
$sql_activity = $conn->prepare("SELECT * FROM riwayat_aktivitas WHERE id_pasien = ? ORDER BY tanggal DESC");
$sql_activity->bind_param("i", $user_id);
$sql_activity->execute();
$result_activity = $sql_activity->get_result();

// Jika data profil ditemukan
if ($result_user->num_rows > 0) {
    $user_data = $result_user->fetch_assoc();
} else {
    echo "Profil pengguna tidak ditemukan.";
    exit;
}

// Menutup koneksi
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
          <li><a href="pengguna.php" class="active">Pengguna</a></li>
        </ul>
        <a href="logout.php" class="user-btn">Logout</a>
      </nav>
    </header>

    <section class="profile-section">
      <div class="profile-container">
        <div class="profile-image">
          <!-- Menampilkan foto profil pengguna, jika ada -->
          <img src="assets/<?php echo !empty($user_data['foto']) ? $user_data['foto'] : 'placeholder.png'; ?>" alt="Foto Pengguna">
        </div>
        <div class="profile-info">
          <h2><?php echo htmlspecialchars($user_data['nama_pasien']); ?></h2>
          <p>Email: <?php echo htmlspecialchars($user_data['username']); ?></p>
          <p>Nomor Telepon: <?php echo htmlspecialchars($user_data['no_kontak_pasien']); ?></p>
          <p>Tanggal Lahir: <?php echo date('d M Y', strtotime($user_data['tgl_lahir'])); ?></p>
          
          <!-- Tombol Edit Profil mengarah ke edit_profile.php -->
          <button class="edit-btn">
            <a href="edit_profile.php?id=<?php echo $user_data['id_pasien']; ?>">Edit Profil</a>
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
          if ($result_activity->num_rows > 0) {
              while($activity = $result_activity->fetch_assoc()) {
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
