<?php
// Koneksi ke database
$servername = "localhost";
$username = "username"; // ganti dengan username Anda
$password = "password"; // ganti dengan password Anda
$dbname = "informatika_medis"; // ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil ID berita dari URL
$id_berita = isset($_GET['id']) ? $_GET['id'] : 0;

// Query untuk mengambil detail berita berdasarkan ID
$sql = "SELECT id_berita, judul_berita, isi_berita, waktu_berita, gambar FROM berita WHERE id_berita = $id_berita";
$result = $conn->query($sql);

// Cek apakah ada berita
if ($result->num_rows > 0) {
    // Menampilkan detail berita
    $row = $result->fetch_assoc();
    $judul = $row['judul_berita'];
    $isi = $row['isi_berita'];
    $waktu = $row['waktu_berita'];
    $gambar = $row['gambar'];
} else {
    echo "Berita tidak ditemukan";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Detail</title>
    <link rel="stylesheet" href="berita-detail.css">
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
                <li><a href="berita.php">Berita</a></li>
                <li><a href="doctor.html">Dokter</a></li>
                <li><a href="layanan.html">Layanan</a></li>
            </ul>
            <a href="login.html" class="user-btn">Login</a>
        </nav>
    </header>

    <section class="berita-detail">
        <div class="container">
            <h1><?= $judul ?></h1>
            <p class="berita-date"><?= $waktu ?></p>
            <img src="assets/<?= $gambar ?>" alt="Gambar Berita">
            <p><?= nl2br($isi) ?></p> <!-- Menampilkan isi berita -->
        </div>
    </section>

    <footer class="footer">
        <div class="footer-content">
            <img src="assets/logo tanpa font.png" alt="MEDIVA Logo" class="footer-logo">
            <ul class="footer-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="berita.php">Berita</a></li>
                <li><a href="doctor.html">Dokter</a></li>
                <li><a href="layanan.html">Layanan</a></li>
            </ul>
            <p>Copyright 2024, MEDIVA Hospital</p>
        </div>
    </footer>
</body>
</html>
