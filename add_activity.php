<?php
// Include the database connection
include('db.php');
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id']; // ID user yang melakukan aktivitas
    $activity = $_POST['activity']; // Deskripsi aktivitas
    $status = $_POST['status']; // Status aktivitas (misalnya: completed, pending)
    $activity_date = $_POST['activity_date']; // Tanggal aktivitas

    // Insert data into database
    $sql = "INSERT INTO activities (user_id, activity, status, activity_date) 
            VALUES ('$user_id', '$activity', '$status', '$activity_date')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Activity added successfully.";
        header("Location: manage_activities.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Activity | Mediva Hospital</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <nav>
            <a href="index.php">Home</a>
            <a href="manage_users.php">Manage Users</a>
            <a href="manage_activities.php">Manage Activities</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h1>Add New Activity</h1>
        
        <!-- Form for adding activity -->
        <form action="add_activity.php" method="POST">
            <label for="user_id">User ID:</label>
            <input type="number" id="user_id" name="user_id" required>

            <label for="activity">Activity:</label>
            <textarea id="activity" name="activity" required></textarea>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
            </select>

            <label for="activity_date">Activity Date:</label>
            <input type="date" id="activity_date" name="activity_date" required>

            <button type="submit">Add Activity</button>
        </form>
    </main>

</body>
</html>
