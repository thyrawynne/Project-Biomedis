<?php
// Include the database connection
include('db.php');
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Mengambil id aktivitas dari URL
if (isset($_GET['id'])) {
    $activity_id = $_GET['id'];

    // Query untuk mendapatkan data aktivitas berdasarkan id
    $sql = "SELECT * FROM activities WHERE id = $activity_id";
    $result = mysqli_query($conn, $sql);

    // Mengecek apakah data ditemukan
    if (mysqli_num_rows($result) > 0) {
        $activity = mysqli_fetch_assoc($result);
    } else {
        echo "Activity not found.";
        exit();
    }
} else {
    echo "No activity selected.";
    exit();
}

// Menangani form submit untuk update aktivitas
if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $activity = $_POST['activity'];
    $status = $_POST['status'];
    $date = $_POST['date'];

    // Query untuk update aktivitas
    $update_sql = "UPDATE activities SET user_id = '$user_id', activity = '$activity', status = '$status', date = '$date' WHERE id = $activity_id";

    if (mysqli_query($conn, $update_sql)) {
        echo "Activity updated successfully.";
        header("Location: manage_activities.php");
        exit();
    } else {
        echo "Error updating activity: " . mysqli_error($conn);
    }
}

// Menutup koneksi
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Activity | Mediva Hospital</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <nav>
            <a href="index.php">Home</a>
            <a href="manage_user.php">Manage Users</a>
            <a href="manage_activities.php">Manage Activities</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h1>Edit Activity</h1>
        
        <!-- Form untuk mengedit aktivitas -->
        <form action="edit_activity.php?id=<?php echo $activity['id']; ?>" method="POST">
            <label for="user_id">User ID:</label>
            <input type="text" id="user_id" name="user_id" value="<?php echo $activity['user_id']; ?>" required>
            
            <label for="activity">Activity:</label>
            <textarea id="activity" name="activity" required><?php echo $activity['activity']; ?></textarea>
            
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Pending" <?php if ($activity['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Completed" <?php if ($activity['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                <option value="In Progress" <?php if ($activity['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
            </select>
            
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo date('Y-m-d', strtotime($activity['date'])); ?>" required>

            <button type="submit" name="submit">Update Activity</button>
        </form>
    </main>

</body>
</html>
