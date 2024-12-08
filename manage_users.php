<?php
// Include the database connection
include('db.php');
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch users from the database
$sql = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);

// Handle user deletion
if (isset($_GET['delete'])) {
    $id_user = $_GET['delete'];
    $delete_sql = "DELETE FROM user WHERE id_user = $id_user";
    if (mysqli_query($conn, $delete_sql)) {
        echo "User deleted successfully.";
        header("Location: manage_user.php");
        exit();
    } else {
        echo "Error deleting user.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | Mediva Hospital</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <nav>
            <a href="admin_dashboard.php">Home</a>
            <a href="manage_users.php">Manage Users</a>
            <a href="manage_activities.php">Manage Activities</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h1>Manage Users</h1>
        
        <!-- Display users -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $user['id_user']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['full_name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $user['id_user']; ?>">Edit</a> |
                            <a href="?delete=<?php echo $user['id_user']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="add_user.php">Add New User</a>
    </main>

</body>
</html>
