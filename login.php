<?php
// Mulai sesi
session_start();

// Koneksi ke database
$host = "localhost";
$username_db = "root"; // Ubah sesuai konfigurasi server Anda
$password_db = ""; // Ubah sesuai konfigurasi server Anda
$database = "informatika_medis";

$conn = new mysqli($host, $username_db, $password_db, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah form telah dikirim
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input
    if (!empty($username) && !empty($password)) {
        // Query untuk memeriksa apakah username dan password cocok
        $query = "SELECT * FROM admin WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Login berhasil, simpan informasi ke sesi
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id_admin'];
            $_SESSION['username'] = $user['username'];

            // Redirect ke dashboard
            header("Location: user_dashboard.php");
            exit();
        } else {
            // Login gagal
            $error_message = "Username atau password salah.";
        }
    } else {
        $error_message = "Harap isi username dan password.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mediva Hospital</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="main-container">
        <div class="login-section">
            <div class="header">
                <h2>Welcome to Mediva Hospital</h2>
                <p>Please enter your username and password</p>
            </div>
            <form class="login-form" method="POST" action="">
                <label for="username">Username</label>
                <div class="input-container">
                    <input type="text" id="username" name="username" placeholder="Enter your username" required />
                    <div class="underline"></div>
                </div>
                <label for="password">Password</label>
                <div class="input-container">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required />
                    <div class="underline"></div>
                </div>
                <?php if (isset($error_message)): ?>
                    <p style="color: red; font-size: 0.9em;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <button type="submit" class="login-button">LOGIN</button>
            </form>
        </div>
        <div class="visuals">
            <img src="./assets/doctor.jpg" alt="Doctor" class="doctor" />
        </div>
    </div>
</body>
</html>
