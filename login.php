<?php
session_start();

$host = 'localhost';
$username = 'root'; // Nama pengguna database
$password = ''; // Password database
$dbname = 'informatika_medis'; // Nama database

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mengamankan input
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Query untuk mencari username
    $sql = "SELECT * FROM admin WHERE username='$username' LIMIT 1";
    $result = $conn->query($sql);

    // Memeriksa apakah username ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Memeriksa apakah password cocok
        if ($password === $user['password']) {
            // Simpan informasi user di session
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: index.php"); // Arahkan ke halaman dashboard setelah login sukses
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Username not found!";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mediva Hospital - Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@400;600&display=swap" />
    <link rel="stylesheet" href="login.css" />
  </head>
  <body>
    <header>
      <div class="header-container">
        <div class="logo">
          <img src="./assets/logo.png" alt="Mediva Logo" />
        </div>
      </div>
    </header>

    <div class="main-container">
      <div class="login-section">
        <div class="header">
          <h2>Welcome to Mediva Hospital</h2>
          <p>Please enter your username and password</p>
        </div>

        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($error)): ?>
          <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form class="login-form" method="POST">
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

          <button type="submit" class="login-button">LOGIN</button>
        </form>
      </div>

      <div class="visuals">
        <img src="./assets/doctor.jpg" alt="Doctor" class="doctor" />
      </div>
    </div>

    <footer>
      <div class="footer-container">
        <p>&copy; 2024 Mediva Hospital. All Rights Reserved.</p>
      </div>
    </footer>

    <script src="login.js"></script>
  </body>
</html>
