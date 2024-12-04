<?php
session_start();

// Periksa apakah pengguna sudah login
$loggedin = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MEDIVA - Rumah Sakit</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div class="container">
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
          <li><a href="doctor.php">Dokter</a></li>
          <li><a href="layanan.php">Layanan</a></li>
        </ul>

        <!-- Tautan Login atau Logout berdasarkan status login -->
        <?php if ($loggedin): ?>
          <a href="logout.php" class="login-btn">Logout</a>
        <?php else: ?>
          <a href="login.php" class="login-btn">Login</a>
        <?php endif; ?>
      </nav>
    </header>    

    <!-- Section 1 Landing Page -->
    <section class="hero">
      <div class="hero-content">
        <h1>Healing Hands, Caring Hearts</h1>
        <p>At our hospital, we are dedicated to providing exceptional care to every patient, ensuring their well-being and comfort throughout their journey with us.</p>
      </div>
      <div class="hero-image">
        <img src="assets/vector.png" alt="Doctor and Patient">
      </div>
    </section>
  </div>

  <!-- Section 2 Dokter -->
  <section class="doctor-section">
    <h2>Trust in Our Team of Experts</h2>
    <div class="doctor-cards">
      <div class="doctor-card">
        <img src="assets/doc1.png" alt="John Doe">
        <h3>John Doe</h3>
        <p>Neurologist</p>
      </div>
      <div class="doctor-card">
        <img src="assets/doc2.png" alt="Emily Brown">
        <h3>Emily Brown</h3>
        <p>Cardiologist</p>
      </div>
      <div class="doctor-card">
        <img src="assets/doc3.png" alt="Michael Johnson">
        <h3>Michael Johnson</h3>
        <p>Oncologist</p>
      </div>
    </div>
    <button class="doctor-btn">Selengkapnya</button>
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