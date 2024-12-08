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

// Cek apakah id berita ada di URL
if (isset($_GET['id'])) {
    $id_berita = $_GET['id'];

    // Query untuk mengambil detail berita berdasarkan id
    $query = "SELECT id_berita, judul_berita, isi_berita, waktu_berita, gambar FROM berita WHERE id_berita = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_berita);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika berita ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $judul_berita = $row['judul_berita'];
        $isi_berita = $row['isi_berita'];
        $waktu_berita = $row['waktu_berita'];
        $gambar = $row['gambar'];
    } else {
        echo "<p>Berita tidak ditemukan.</p>";
        exit();
    }
} else {
    echo "<p>Id berita tidak ditemukan dalam URL.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berita - MEDIVA</title>
    <link rel="stylesheet" href="berita-detail.css">
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
                <li><a href="doctor.php">Dokter</a></li>
                <li><a href="layanan.php">Layanan</a></li>
            </ul>
            <a href="pengguna.php" class="user-btn">Pengguna</a>
        </nav>
    </header>

    <section class="berita-detail">
        <div class="container">
            <h1><?php echo htmlspecialchars($judul_berita); ?></h1>
            <p class="berita-date"><?php echo date("d F Y", strtotime($waktu_berita)); ?></p>
            <div class="berita-image">
                <img src="assets/<?php echo htmlspecialchars($gambar); ?>" alt="Thumbnail">
            </div>
            <div class="berita-content">
                <p><?php echo nl2br(htmlspecialchars($isi_berita)); ?></p>
            </div>
        </div>
    </section>

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
$stmt->close();
$conn->close();
?>
