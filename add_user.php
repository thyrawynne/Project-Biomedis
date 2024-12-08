<?php
// Include the database connection
include('db.php');
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle form submission to add a new user
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $insert_sql = "INSERT INTO user (username, full_name, email, password, role) VALUES ('$username', '$full_name', '$email', '$hashed_password', '$role')";

    if (mysqli_query($conn, $insert_sql)) {
        echo "New user added successfully.";
        header("Location: manage_user.php");
        exit();
    } else {
        echo "Error adding user: " . mysqli_error($conn);
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
    <title>Add User | Mediva Hospital</title>
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
        <h1>Add New User</h1>
        
        <!-- Add user form -->
        <form action="add_user.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            <button type="submit" name="submit">Add User</button>
        </form>
    </main>

</body>
</html>
