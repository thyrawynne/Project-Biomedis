<?php
// Menyambung ke database
include('db.php'); 

// Menarik data admin dari database
$sql = "SELECT * FROM admin";
$result = mysqli_query($conn, $sql);
$adminData = mysqli_fetch_assoc($result);

// Query untuk menghitung jumlah pengguna
$userCountSql = "SELECT COUNT(*) AS total_users FROM user";
$userCountResult = mysqli_query($conn, $userCountSql);
$userCountData = mysqli_fetch_assoc($userCountResult);

// Query untuk menghitung jumlah aktivitas
$activityCountSql = "SELECT COUNT(*) AS total_activities FROM activities"; 
$activityCountResult = mysqli_query($conn, $activityCountSql);
$activityCountData = mysqli_fetch_assoc($activityCountResult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Mediva Hospital</title>
  <link rel="stylesheet" href="admin_styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">
      <img src="assets/logo.png" alt="Mediva Logo">
    </div>
    <ul>
      <li><a href="admin_dashboard.php">Dashboard</a></li>
      <li><a href="manage_users.php">Manage Users</a></li>
      <li><a href="manage_activities.php">Manage Activities</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <header>
      <h1>Welcome, <?php echo $adminData['username']; ?></h1>
    </header>

    <!-- Stats Overview -->
    <section class="stats">
      <div class="stat-card">
        <h3>Total Users</h3>
        <p><?php echo $userCountData['total_users']; ?></p> <!-- Dynamic count of users -->
      </div>
      <div class="stat-card">
        <h3>Total Activities</h3>
        <p><?php echo $activityCountData['total_activities']; ?></p> <!-- Dynamic count of activities -->
      </div>
    </section>

    <!-- User Management -->
    <section class="user-management">
      <h2>User List</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Menarik data pengguna dari tabel user
          $userSql = "SELECT * FROM user";
          $userResult = mysqli_query($conn, $userSql);

          while ($user = mysqli_fetch_assoc($userResult)) {
            echo "<tr>
                    <td>" . $user['id_user'] . "</td>
                    <td>" . $user['username'] . "</td>
                    <td>" . $user['full_name'] . "</td>
                    <td>
                      <a href='edit_user.php?id=" . $user['id_user'] . "'>Edit</a> | 
                      <a href='delete_user.php?id=" . $user['id_user'] . "'>Delete</a>
                    </td>
                  </tr>";
          }
          ?>
        </tbody>
      </table>
    </section>
  </div>

  <footer>
    <p>&copy; 2024 Mediva Hospital. All Rights Reserved.</p>
  </footer>

</body>
</html>
