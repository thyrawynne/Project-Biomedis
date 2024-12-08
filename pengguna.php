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

// Menyusun query untuk mengambil data profil pengguna
// Asumsikan session sudah dimulai untuk mendapatkan ID pengguna yang login
session_start();
$user_id = $_SESSION['user_id']; // ID pengguna yang login, misalnya disimpan dalam sesi

$sql_user = "SELECT * FROM pasien WHERE id_pasien = $user_id";
$result_user = $conn->query($sql_user);

// Menyusun query untuk mengambil riwayat aktivitas pengguna
$sql_activity = "SELECT * FROM riwayat_aktivitas WHERE id_pasien = $user_id ORDER BY tanggal DESC";
$result_activity = $conn->query($sql_activity);

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
          <img src="assets/placeholder.png" alt="Foto Pengguna">
        </div>
        <div class="profile-info">
          <h2><?php echo $user_data['nama_pasien']; ?></h2>
          <p>Email: <?php echo $user_data['username']; ?></p>
          <p>Nomor Telepon: <?php echo $user_data['no_kontak_pasien']; ?></p>
          <p>Tanggal Lahir: <?php echo date('d M Y', strtotime($user_data['tgl_lahir'])); ?></p>
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
          // Menampilkan riwayat aktivitas pengguna
          if ($result_activity->num_rows > 0) {
              while($activity = $result_activity->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td>' . date('d M Y', strtotime($activity['tanggal'])) . '</td>';
                  echo '<td>' . $activity['aktivitas'] . '</td>';
                  echo '<td>' . $activity['status'] . '</td>';
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
