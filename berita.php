<?php
include('db.php');

// Query untuk mengambil berita
$sql = "SELECT id_berita, judul_berita, isi_berita, waktu_berita, gambar FROM berita ORDER BY waktu_berita DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Menampilkan data berita
    while($row = $result->fetch_assoc()) {
        echo '<a href="berita_detail.php?id=' . $row['id_berita'] . '" class="berita-link">
                <article class="berita-card">
                    <img src="assets/' . $row['gambar'] . '" alt="Thumbnail">
                    <div class="berita-content">
                        <h2>' . $row['judul_berita'] . '</h2>
                        <p class="berita-date">' . $row['waktu_berita'] . '</p>
                        <p>' . substr($row['isi_berita'], 0, 150) . '...</p>
                    </div>
                </article>
            </a>';
    }
} else {
    echo "No news available.";
}

$conn->close();
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
      <a href="index.html">
        <img src="assets/logo.png" alt="MEDIVA Logo">
      </a>
    </div>
    <ul class="nav-links">
      <li><a href="index.html">Home</a></li>
      <li><a href="berita.html">Berita</a></li>
      <li><a href="doctor.html">Dokter</a></li>
      <li><a href="layanan.html">Layanan</a></li>
    </ul>
    <a href="login.html" class="user-btn">Login</a>
  </nav>
  </header>

  <section class="berita">
    <div class="container">
      <h1>Berita</h1>
      <div class="berita-grid">
        <a href="berita1.html" class="berita-link">
          <article class="berita-card">
            <img src="assets/berita1.png" alt="Thumbnail">
            <div class="berita-content">
              <h2>Penemuan Baru dalam Formulasi Obat Generik</h2>
              <p class="berita-date">11 Januari 2024</p>
              <p>Penelitian terbaru menunjukkan formulasi baru obat generik meningkatkan efektivitas pengobatan hingga 20%.</p>
            </div>
          </article>
        </a>
        <a href="berita2.html" class="berita-link">
          <article class="berita-card">
            <img src="assets/berita2.png" alt="Thumbnail">
            <div class="berita-content">
              <h2>Konsumsi Makanan Seimbang untuk Kesehatan Optimal</h2>
              <p class="berita-date">8 April 2024</p>
              <p>Ahli gizi menggarisbawahi pentingnya pola makan sehat dan seimbang untuk meningkatkan kualitas hidup.</p>
            </div>
          </article>
        </a>
        <a href="berita3.html" class="berita-link">
          <article class="berita-card">
            <img src="assets/berita3.png" alt="Thumbnail">
            <div class="berita-content">
              <h2>Manfaat Yoga bagi Kesehatan Mental dan Fisik</h2>
              <p class="berita-date">22 Agustus 2024</p>
              <p>Yoga semakin diminati oleh masyarakat urban sebagai cara untuk mengurangi stres dan meningkatkan kebugaran.</p>
            </div>
          </article>
        </a>
        <a href="berita4.html" class="berita-link">
          <article class="berita-card">
            <img src="assets/berita4.png" alt="Thumbnail">
            <div class="berita-content">
              <h2>Peningkatan Layanan Kesehatan dengan Tenaga Profesional Terlatih</h2>
              <p class="berita-date">28 November 2024</p>
              <p>Rumah sakit dan fasilitas kesehatan di seluruh negeri terus meningkatkan pelayanan.</p>
            </div>
          </article>
        </a>
      </div>
    </div>
    <button class="berita-btn">Selengkapnya</button>
  </section>  

  <!-- Footer -->
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
</body>
</html>
