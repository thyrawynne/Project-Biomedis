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

// Query untuk mengambil data dokter dari tabel 'dokter'
$query = "SELECT dokter.id_dokter, dokter.nama_dokter, dokter.no_wa, dokter.gambar, dokter.spesialisasi, poli.nama_poli 
          FROM dokter 
          JOIN poli ON dokter.id_poli = poli.id_poli"; // Menggabungkan dengan tabel poli untuk mendapatkan nama poli
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MEDIVA - Dokter</title>
  <link rel="stylesheet" href="doctor.css">
</head>
<body>
  <header>
    <!-- Navbar -->
    <nav class="navbar">
      <div class="logo">
        <a href="index.php">
          <img src="assets/logo.png" alt="MEDIVA Logo">
        </a>
      </div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="berita.php">Berita</a></li>
        <li><a href="doctor.php" class="active">Dokter</a></li>
        <li><a href="layanan.php">Layanan</a></li>
      </ul>
      <a href="pengguna.php" class="user-btn">Pengguna</a>
    </nav>
  </header>

  <main>
    <section class="doctors">
      <div class="container">
        <h2>Meet Our Doctors</h2>
        <p>Doctors Who Treat You Like Family</p>
        <div class="doctor-grid">
          <?php
          // Menampilkan data dokter dalam bentuk kartu
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              // Ambil data dari query
              $id_dokter = $row['id_dokter'];
              $nama_dokter = $row['nama_dokter'];
              $no_wa = $row['no_wa'];
              $gambar = $row['gambar'];
              $spesialisasi = $row['spesialisasi'];
              $nama_poli = $row['nama_poli'];
              ?>
              <div class="doctor-card">
                <img src="assets/<?php echo $gambar; ?>" alt="<?php echo $nama_dokter; ?>">
                <h3><a href="doctor-detail.php?id=<?php echo $id_dokter; ?>"><?php echo $nama_dokter; ?></a></h3>
                <p><strong>Spesialisasi:</strong> <?php echo $spesialisasi; ?></p>
                <p><strong>Poli:</strong> <?php echo $nama_poli; ?></p>
                <p><strong>Contact:</strong> <a href="https://wa.me/<?php echo $no_wa; ?>" target="_blank">WhatsApp</a></p>
              </div>
              <?php
            }
          } else {
            echo "<p>No doctors available at the moment.</p>";
          }
          ?>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-container">
      <div class="footer-logo">
        <img src="assets/logo1.png" alt="Mediva Logo">
      </div>
      <div class="footer-nav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="berita.php">Berita</a></li>
          <li><a href="doctor.php">Dokter</a></li>
          <li><a href="layanan.php">Layanan</a></li>
        </ul>
      </div>
      <div class="footer-copyright">
        <p>Copyright 2024, MEDIVA Hospital</p>
      </div>
    </div>
  </footer>
</body>
</html>

<?php
// Menutup koneksi ke database
$conn->close();
?>
