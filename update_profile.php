<?php
// Mulai sesi
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Koneksi ke database
$host = "localhost";
$username_db = "root"; // Sesuaikan dengan konfigurasi Anda
$password_db = ""; // Sesuaikan dengan konfigurasi Anda
$database = "informatika_medis";

$conn = new mysqli($host, $username_db, $password_db, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['user_id'];

// Periksa apakah data form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];

    // Query untuk memperbarui profil
    $query = "UPDATE user SET email = ?, phone = ?, birthdate = ? WHERE id_user = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $email, $phone, $birthdate, $user_id);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "Profil berhasil diperbarui.";
        // Anda bisa mengalihkan pengguna ke halaman lain, seperti dashboard pengguna
        header("Location: user_dashboard.php");
        exit();
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }
}

$conn->close();
?>
