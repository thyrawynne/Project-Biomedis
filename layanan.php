<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "informatika_medis";  // Sesuaikan dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel 'poli'
$query = "SELECT * FROM poli";  // Sesuaikan dengan nama tabel Anda
$result = $conn->query($query);
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
        // Menampilkan data poli dalam bentuk kartu layanan
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            // Ambil nama dan deskripsi dari setiap poli
            $nama_poli = $row['nama_poli'];
            $deskripsi_poli = $row['deskripsi_poli'];
            ?>
            <a href="poli_detail.php?id=<?php echo $row['id_poli']; ?>" class="service-card">
              <h3><?php echo $nama_poli; ?></h3>
              <p><?php echo $deskripsi_poli; ?></p>
            </a>
            <?php
          }
        } else {
          echo "<p>No services available at the moment.</p>";
        }
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

<?php
// Menutup koneksi ke database
$conn->close();
?>
