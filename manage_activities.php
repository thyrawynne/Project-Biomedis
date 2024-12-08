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
$sql = "SELECT * FROM activities ORDER BY date DESC";
$result = mysqli_query($conn, $sql);

// Handle activity deletion
if (isset($_GET['delete'])) {
    $activity_id = $_GET['delete']; // Use ID activity for deletion
    $delete_sql = "DELETE FROM activities WHERE id = $activity_id";
    
    if (mysqli_query($conn, $delete_sql)) {
        echo "Activity deleted successfully.";
        header("Location: manage_activities.php");
        exit();
    } else {
        echo "Error deleting activity: " . mysqli_error($conn);
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
            <a href="manage_users.php">Manage Users</a>
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
                    <th>User ID</th>
                    <th>Activity</th>
                    <th>Status</th>
                    <th>Activity Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if the query was successful
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($activity = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $activity['id'] . '</td>';
                        echo '<td>' . $activity['user_id'] . '</td>';
                        echo '<td>' . $activity['activity'] . '</td>';
                        echo '<td>' . $activity['status'] . '</td>';
                        echo '<td>' . date('d M Y', strtotime($activity['date'])) . '</td>';
                        echo '<td>';
                        echo '<a href="edit_activity.php?id=' . $activity['id'] . '">Edit</a> | ';
                        echo '<a href="?delete=' . $activity['id'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo "<tr><td colspan='6'>No activities found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="add_activity.php">Add New Activity</a>
    </main>

</body>
</html>
