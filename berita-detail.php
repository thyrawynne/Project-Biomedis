<?php
include('db.php');

// Mengambil id_berita dari URL
$id_berita = $_GET['id'];

// Query untuk mengambil detail berita berdasarkan id
$sql = "SELECT id_berita, judul_berita, isi_berita, waktu_berita, gambar FROM berita WHERE id_berita = $id_berita";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo '<h1>' . $row['judul_berita'] . '</h1>
          <p class="berita-date">' . $row['waktu_berita'] . '</p>
          <img src="assets/' . $row['gambar'] . '" alt="Image Thumbnail" class="berita-thumbnail">
          <p>' . $row['isi_berita'] . '</p>';
} else {
    echo "Berita tidak ditemukan.";
}

$conn->close();
?>
