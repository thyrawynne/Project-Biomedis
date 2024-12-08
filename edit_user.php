<?php
// Include the database connection
include('db.php');
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get the user ID from the URL
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];

    // Query to fetch the user details from the database
    $sql = "SELECT * FROM user WHERE id_user = $id_user";
    $result = mysqli_query($conn, $sql);

    // Check if the user exists
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "No user selected.";
    exit();
}

// Handle form submission to update the user
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update user details in the database
    $update_sql = "UPDATE user SET username = '$username', full_name = '$full_name', email = '$email', role = '$role' WHERE id_user = $id_user";

    if (mysqli_query($conn, $update_sql)) {
        echo "User updated successfully.";
        header("Location: manage_user.php");
        exit();
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | Mediva Hospital</title>
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
        <h1>Edit User</h1>
        
        <!-- Edit user form -->
        <form action="edit_user.php?id=<?php echo $user['id_user']; ?>" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
            
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo $user['full_name']; ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
            </select>

            <button type="submit" name="submit">Update User</button>
        </form>
    </main>

</body>
</html>
