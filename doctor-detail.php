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

// Memastikan ID dokter diterima dalam URL
if (isset($_GET['id'])) {
    $id_dokter = $_GET['id'];
    // Query untuk mengambil data detail dokter berdasarkan id_dokter
    $sql = "SELECT * FROM dokter WHERE id_dokter = $id_dokter";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $doctor = $result->fetch_assoc();
    } else {
        echo "Dokter tidak ditemukan.";
        exit;
    }
} else {
    echo "ID dokter tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MEDIVA - Detail Dokter</title>
  <link rel="stylesheet" href="doctor-detail.css">
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
    <section class="doctor-detail">
        <div class="container">
            <h2><?php echo $doctor['nama_dokter']; ?></h2>
            <div class="doctor-info">
                <img src="assets/<?php echo $doctor['gambar']; ?>" alt="<?php echo $doctor['nama_dokter']; ?>">
                <div class="doctor-bio">
                    <p><strong>Spesialisasi:</strong> <?php echo $doctor['spesialisasi']; ?></p>
                    <p><strong>No. WA:</strong> <?php echo $doctor['no_wa']; ?></p>
                    <p><strong>Poliklinik:</strong> <?php echo $doctor['id_poli']; ?> </p>
                    <a href="hubungi-dokter.php?id=<?php echo $doctor['id_dokter']; ?>" class="contact-btn">Hubungi Dokter</a>
                </div>
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
