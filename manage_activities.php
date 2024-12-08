<?php
// Include the database connection
include('db.php');
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch activities from the database
$sql = "SELECT * FROM activities ORDER BY activity_date DESC";
$result = mysqli_query($conn, $sql);

// Handle activity deletion
if (isset($_GET['delete'])) {
    $id_activity = $_GET['delete'];
    $delete_sql = "DELETE FROM activities WHERE id_activity = $id_activity";
    if (mysqli_query($conn, $delete_sql)) {
        echo "Activity deleted successfully.";
        header("Location: manage_activities.php");
        exit();
    } else {
        echo "Error deleting activity.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Activities | Mediva Hospital</title>
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
        <h1>Manage Activities</h1>
        
        <!-- Display activities -->
        <table>
            <thead>
                <tr>
                    <th>Activity ID</th>
                    <th>User</th>
                    <th>Activity</th>
                    <th>Status</th>
                    <th>Activity Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($activity = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $activity['id_activity']; ?></td>
                        <td><?php echo $activity['user_id']; ?></td>
                        <td><?php echo $activity['activity']; ?></td>
                        <td><?php echo $activity['status']; ?></td>
                        <td><?php echo $activity['activity_date']; ?></td>
                        <td>
                            <a href="edit_activity.php?id=<?php echo $activity['id_activity']; ?>">Edit</a> |
                            <a href="?delete=<?php echo $activity['id_activity']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="add_activity.php">Add New Activity</a>
    </main>

</body>
</html>
