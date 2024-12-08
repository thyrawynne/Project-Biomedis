<?php
// Menghubungkan ke database
include('db.php');
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Mengambil ID pengguna dari URL
$id_pasien = $_GET['id'];  // ID pengguna yang ingin diedit

// Mengambil data pengguna dari database
$sql_user = "SELECT * FROM pasien WHERE id_pasien = $id_pasien";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $user_data = $result_user->fetch_assoc();
} else {
    echo "Pengguna tidak ditemukan.";
    exit();
}

// Mengupdate data pengguna
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_kontak = $_POST['no_kontak'];

    // Query untuk memperbarui profil
    $sql_update = "UPDATE pasien SET nama_pasien = '$nama', username = '$email', no_kontak_pasien = '$no_kontak' WHERE id_pasien = $id_pasien";

    if ($conn->query($sql_update) === TRUE) {
        echo "Profil berhasil diperbarui.";
        header("Location: pengguna.php");
        exit();
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Pengguna</title>
    <link rel="stylesheet" href="pengguna.css">
</head>
<body>
    <div class="container">
        <header>
            <nav class="navbar">
                <div class="logo">
                    <a href="index.php"><img src="assets/logo.png" alt="MEDIVA Logo"></a>
                </div>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="berita.php">Berita</a></li>
                    <li><a href="doctor.php">Dokter</a></li>
                    <li><a href="layanan.php">Layanan</a></li>
                    <li><a href="pengguna.php">Pengguna</a></li>
                </ul>
                <a href="logout.php" class="user-btn">Logout</a>
            </nav>
        </header>

        <section class="edit-profile-section">
            <h2>Edit Profil Pengguna</h2>
            <form action="edit_profile.php?id=<?php echo $user_data['id_pasien']; ?>" method="POST">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" value="<?php echo $user_data['nama_pasien']; ?>" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo $user_data['username']; ?>" required>

                <label for="no_kontak">Nomor Telepon</label>
                <input type="text" name="no_kontak" id="no_kontak" value="<?php echo $user_data['no_kontak_pasien']; ?>" required>

                <button type="submit" class="submit-btn">Simpan Perubahan</button>
            </form>
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
    </div>
</body>
</html>
