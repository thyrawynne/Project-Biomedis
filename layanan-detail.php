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

// Ambil ID layanan dari URL
$id_layanan = $_GET['id'];

// Query untuk mengambil data detail layanan berdasarkan ID
$query = "SELECT * FROM layanan WHERE id_layanan = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_layanan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nama_layanan = $row['nama_layanan'];
    $deskripsi_layanan = $row['deskripsi_layanan'];
    $ikon_layanan = $row['ikon_layanan'];
} else {
    echo "Layanan tidak ditemukan.";
    exit();
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDIVA - Detail Layanan</title>
    <link rel="stylesheet" href="layanan-detail.css">
</head>

<body>
    <div class="container">
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
                    <li><a href="doctor.html">Dokter</a></li>
                    <li><a href="layanan.html">Layanan</a></li>
                </ul>
                <a href="pengguna.html" class="user-btn">Pengguna</a>
            </nav>
        </header>

        <!-- Section Layanan Detail -->
        <section class="layanan-detail-section">
            <div class="layanan-detail-card">
                <div class="layanan-image">
                    <img src="assets/<?php echo $ikon_layanan; ?>" alt="<?php echo $nama_layanan; ?> Icon">
                </div>
                <div class="layanan-content">
                    <h2><?php echo $nama_layanan; ?></h2>
                    <p><?php echo $deskripsi_layanan; ?></p>
                </div>
            </div>
        </section>
    </div>

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

<?php
$conn->close();
?>
