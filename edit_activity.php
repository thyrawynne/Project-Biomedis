<?php
// Include the database connection
include('db.php');
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle form submission for editing activity
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_activity = $_POST['id_activity']; // ID aktivitas yang akan diedit
    $user_id = $_POST['user_id']; // ID user yang melakukan aktivitas
    $activity = $_POST['activity']; // Deskripsi aktivitas
    $status = $_POST['status']; // Status aktivitas
    $activity_date = $_POST['activity_date']; // Tanggal aktivitas

    // Update data into database
    $sql = "UPDATE activities SET 
            user_id = '$user_id', 
            activity = '$activity', 
            status = '$status', 
            activity_date = '$activity_date' 
            WHERE id_activity = $id_activity";

    if (mysqli_query($conn, $sql)) {
        echo "Activity updated successfully.";
        header("Location: manage_activities.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch the existing activity data to populate the form
if (isset($_GET['id'])) {
    $id_activity = $_GET['id'];
    $sql = "SELECT * FROM activities WHERE id_activity = $id_activity";
    $result = mysqli_query($conn, $sql);
    $activity_data = mysqli_fetch_assoc($result);
} else {
    echo "Activity not found.";
    exit();
}
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
        
        <!-- Form for editing activity -->
        <form action="edit_activity.php" method="POST">
            <input type="hidden" name="id_activity" value="<?php echo $activity_data['id_activity']; ?>">

            <label for="user_id">User ID:</label>
            <input type="number" id="user_id" name="user_id" value="<?php echo $activity_data['user_id']; ?>" required>

            <label for="activity">Activity:</label>
            <textarea id="activity" name="activity" required><?php echo $activity_data['activity']; ?></textarea>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="completed" <?php echo ($activity_data['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                <option value="pending" <?php echo ($activity_data['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
            </select>

            <label for="activity_date">Activity Date:</label>
            <input type="date" id="activity_date" name="activity_date" value="<?php echo $activity_data['activity_date']; ?>" required>

            <button type="submit">Update Activity</button>
        </form>
    </main>

</body>
</html>
