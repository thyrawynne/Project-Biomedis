<?php
// Menghubungkan ke database
$host = 'localhost';
$db = 'informatika_medis';  // Ganti dengan nama database Anda
$user = 'root';             // Ganti dengan username database Anda
$pass = '';                 // Ganti dengan password database Anda

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data dokter
$sql = "SELECT id_dokter, nama_dokter, gambar, spesialisasi FROM dokter";
$result = $conn->query($sql);
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
                if ($result->num_rows > 0) {
                    while ($doctor = $result->fetch_assoc()) {
                        echo '<div class="doctor-card">';
                        echo '<img src="assets/' . $doctor['gambar'] . '" alt="' . $doctor['nama_dokter'] . '">';
                        echo '<h5><a href="doctor-detail.php?id=' . $doctor['id_dokter'] . '">' . $doctor['nama_dokter'] . '</a></h5>';
                        echo '<p>' . $doctor['spesialisasi'] . '</p>';
                        echo '<a href="hubungi-dokter.php?id=' . $doctor['id_dokter'] . '" class="hubungi-dokter">Hubungi Dokter</a>';
                        echo '</div>';
                    }
                } else {
                    echo "Tidak ada dokter yang ditemukan.";
                }
                ?>
            </div>
        </div>
    </section>
  </main>
  <footer>
    <div class="footer-container">
      <div class="footer-logo">
        <img src="logo1.png" alt="Mediva Logo">
      </div>
      <div class="footer-nav">
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Berita</a></li>
          <li><a href="#">Dokter</a></li>
          <li><a href="#">Layanan</a></li>
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
// Menutup koneksi
$conn->close();
?>
