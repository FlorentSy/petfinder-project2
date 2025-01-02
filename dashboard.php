<?php
session_start();
require 'config.php';
include_once 'header.php';
// Ensure only admins can access this page
if ($_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

// Fetch users
$sql = "SELECT * FROM users";
$query = $pdo->prepare($sql);
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Dashboard</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">User Management</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Username</th>
                <th>Email</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['surname']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['is_admin'] == 1 ? 'Yes' : 'No'; ?></td>
                    <td>
                        <a href="update_user.php?id=<?php echo $user['id']; ?>" class="btn btn-success btn-sm">Update</a>
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<footer>
<div class="text-center p-2">
        © 2025 Copyright:
        <a class="text-white" href="#"> <strong>Petfinder</strong></a>
    </div>
</footer>
<style>
  html, body {
    height: 100%; /* Make sure the html and body cover the full height of the viewport */
    margin: 0; /* Remove default margin */
    display: flex;
    flex-direction: column; /* Organizes content in a column */
}

body {
    flex: 1; /* Allows the body to expand to fill available space */
}

footer {
    width: 100%; /* Ensures the footer stretches across the full width of the viewport */
    background-color: #3A6D8C; /* Background color */
    color: white; /* Text color */
    text-align: center; /* Centers the text */
    padding: 1rem 0; /* Padding above and below the content */
    position: absolute;
    bottom: 0; /* Sticks to the bottom */
    left: 0; /* Aligns to the left edge */
}
footer a {
        text-decoration: none;
        color: white; /* Ensure text color is white or another color based on your design */
    }
</style>
