<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "informatika_medis";

$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah parameter ID dokter tersedia
if (!isset($_GET['id'])) {
    die("ID dokter tidak ditemukan.");
}

$id_dokter = intval($_GET['id']);

// Query untuk mendapatkan detail dokter
$query_dokter = "SELECT * FROM dokter WHERE id_dokter = $id_dokter";
$result_dokter = $conn->query($query_dokter);

// Jika data dokter ditemukan
if ($result_dokter->num_rows > 0) {
    $dokter = $result_dokter->fetch_assoc();
    $nama_dokter = $dokter['nama_dokter'];
    $spesialisasi = $dokter['spesialisasi'];
    $gambar = $dokter['gambar'];
    $no_wa = $dokter['no_wa'];

    // Query untuk mendapatkan jadwal dokter berdasarkan id_dokter
    $query_jadwal = "SELECT * FROM jadwal_dokter WHERE id_dokter = $id_dokter ORDER BY hari";
    $result_jadwal = $conn->query($query_jadwal);
} else {
    die("Dokter tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Dokter - <?php echo htmlspecialchars($nama_dokter); ?></title>
  <link rel="stylesheet" href="doctor.css">
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="logo">
        <a href="index.html">
          <img src="assets/logo.png" alt="MEDIVA Logo">
        </a>
      </div>
      <ul class="nav-links">
        <li><a href="index.html">Home</a></li>
        <li><a href="berita.html">Berita</a></li>
        <li><a href="doctor.php" class="active">Dokter</a></li>
        <li><a href="layanan.html">Layanan</a></li>
      </ul>
      <a href="pengguna.html" class="user-btn">Pengguna</a>
    </nav>
  </header>

  <main>
    <section class="doctor-detail">
      <div class="doctor-card-detail">
        <img src="assets/<?php echo htmlspecialchars($gambar); ?>" alt="<?php echo htmlspecialchars($nama_dokter); ?>">
        <div class="doctor-info">
          <h2><?php echo htmlspecialchars($nama_dokter); ?></h2>
          <p><?php echo htmlspecialchars($spesialisasi); ?></p>
          <table>
            <tr>
              <th>No</th>
              <th>Hari</th>
              <th>Jam</th>
            </tr>
            <?php
            if ($result_jadwal->num_rows > 0) {
                $no = 1;
                while ($jadwal = $result_jadwal->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($jadwal['hari']) . "</td>";
                    echo "<td>" . htmlspecialchars($jadwal['jam']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Jadwal tidak tersedia.</td></tr>";
            }
            ?>
          </table>
          <a href="https://wa.me/<?php echo htmlspecialchars($no_wa); ?>" class="hubungi-dokter">Hubungi Dokter</a>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <div class="footer-container">
      <div class="footer-logo">
        <img src="assets/logo1.png" alt="Mediva Logo">
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
// Tutup koneksi
$conn->close();
?>
