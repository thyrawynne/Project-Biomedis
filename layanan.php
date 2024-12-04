<?php
// Menghubungkan ke database
$host = 'localhost';
$username = 'root'; // Nama pengguna database
$password = ''; // Password database
$dbname = 'informatika_medis'; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil data layanan dari tabel poli
$sql = "SELECT * FROM poli";
$result = $conn->query($sql);

// Memulai sesi untuk login (jika diperlukan)
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MEDIVA - Layanan</title>
  <link rel="stylesheet" href="layanan.css">
</head>

<body>
  <div class="container">
    <!-- Navbar -->
    <header>
      <nav class="navbar">
        <div class="logo">
          <a href="index.php">
            <img src="assets/logo.png" alt="MEDIVA Logo">
          </a>
        </div>
        <ul class="nav-links">
          <li><a href="index.php">Home</a></li>
          <li><a href="berita.php">Berita</a></li>
          <li><a href="doctor.php">Dokter</a></li>
          <li><a href="layanan.php" class="active">Layanan</a></li>
        </ul>
        <a href="pengguna.php" class="user-btn">Pengguna</a>
      </nav>
    </header>

    <!-- Section Our Services -->
    <section class="services-section">
      <h2>Our Services</h2>
      <p>Discover the wide range of health services we offer to cater to your needs.</p>
      <div class="service-cards">
        <?php
        // Cek apakah ada data layanan
        if ($result->num_rows > 0) {
            // Output data layanan
            while($row = $result->fetch_assoc()) {
                echo '<a href="' . strtolower($row["nama_poli"]) . '.php" class="service-card">';
                echo '<img src="assets/' . strtolower($row["nama_poli"]) . '.png" alt="' . $row["nama_poli"] . ' Icon">';
                echo '<h3>' . $row["nama_poli"] . '</h3>';
                echo '</a>';
            }
        } else {
            echo "<p>No services available.</p>";
        }

        // Menutup koneksi
        $conn->close();
        ?>
      </div>
    </section>
  </div>

  <!-- Footer -->
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
</body>
</html>
