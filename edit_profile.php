<?php
// Mulai sesi
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Koneksi ke database
$host = "localhost";
$username_db = "root"; // Sesuaikan dengan konfigurasi Anda
$password_db = ""; // Sesuaikan dengan konfigurasi Anda
$database = "informatika_medis";

$conn = new mysqli($host, $username_db, $password_db, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data pengguna berdasarkan sesi
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE id_user = ?"; // Gantilah 'id' dengan 'id_user'
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil Pengguna | Mediva Hospital</title>
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
      <h2>Edit Profil</h2>
      <form method="POST" action="update_profile.php">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

        <label for="phone">Nomor Telepon:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required><br>

        <label for="birthdate">Tanggal Lahir:</label>
        <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>" required><br>

        <button type="submit">Update Profil</button>
      </form>
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
