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

// Query untuk mengambil data berita dari tabel 'berita'
$query = "SELECT id_berita, judul_berita, isi_berita, waktu_berita, gambar FROM berita ORDER BY waktu_berita DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MEDIVA - Berita</title>
  <link rel="stylesheet" href="berita.css">
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
      <li><a href="berita.php" class="active">Berita</a></li>
      <li><a href="doctor.php">Dokter</a></li>
      <li><a href="layanan.php">Layanan</a></li>
    </ul>
    <a href="login.php" class="user-btn">Login</a>
  </nav>
  </header>

  <section class="berita">
    <div class="container">
      <h1>Berita</h1>
      <div class="berita-grid">
        <?php
        // Menampilkan data berita dalam bentuk kartu
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            // Ambil data dari query
            $id_berita = $row['id_berita'];
            $judul_berita = $row['judul_berita'];
            $isi_berita = $row['isi_berita'];
            $waktu_berita = $row['waktu_berita'];
            $gambar = $row['gambar'];
            ?>
            <a href="berita-detail.php?id=<?php echo $id_berita; ?>" class="berita-link">
              <article class="berita-card">
                <img src="assets/<?php echo $gambar; ?>" alt="Thumbnail">
                <div class="berita-content">
                  <h2><?php echo $judul_berita; ?></h2>
                  <p class="berita-date"><?php echo date("d F Y", strtotime($waktu_berita)); ?></p>
                  <p><?php echo substr($isi_berita, 0, 150) . '...'; ?></p>
                </div>
              </article>
            </a>
            <?php
          }
        } else {
          echo "<p>No news available at the moment.</p>";
        }
        ?>
      </div>
    </div>
    <button class="berita-btn">Selengkapnya</button>
  </section>  

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
