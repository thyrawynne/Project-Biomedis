<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "informatika_medis";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil daftar dokter dari database
$sql = "SELECT dokter.id_dokter, dokter.nama_dokter, dokter.spesialisasi, poli.nama_poli, dokter.gambar
        FROM dokter 
        JOIN poli ON dokter.id_poli = poli.id_poli";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Dokter - MEDIVA Hospital</title>
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
                <li><a href="index.php">Home</a></li>
                <li><a href="berita.php">Berita</a></li>
                <li><a href="doctor.php">Dokter</a></li>
                <li><a href="layanan.php">Layanan</a></li>
            </ul>
            <a href="pengguna.html" class="user-btn">Pengguna</a>
        </nav>
    </header>

    <main>
        <section class="doctor-list">
            <h1>Daftar Dokter</h1>
            <div class="doctor-cards">
                <?php
                if ($result->num_rows > 0) {
                    while ($dokter = $result->fetch_assoc()) {
                        echo '<div class="doctor-card">';
                        echo '<img src="assets/' . $dokter['gambar'] . '" alt="' . $dokter['nama_dokter'] . '">';
                        echo '<h3><a href="doctor-detail.php?id=' . $dokter['id_dokter'] . '">' . $dokter['nama_dokter'] . '</a></h3>';
                        echo '<p>' . $dokter['spesialisasi'] . ' - ' . $dokter['nama_poli'] . '</p>';
                        echo '<a href="doctor-detail.php?id=' . $dokter['id_dokter'] . '" class="detail-btn">Lihat Detail</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Tidak ada dokter yang tersedia saat ini.</p>';
                }
                ?>
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
$conn->close();
?>
