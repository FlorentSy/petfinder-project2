<?php
session_start();
require 'config.php';
include_once 'header.php';

// Ensure only admins can access this page
if ($_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

// Fetch pets
$sql = "SELECT * FROM pets";
$query = $pdo->prepare($sql);
$query->execute();
$pets = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Pets Dashboard</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            flex: 1;
        }

        .container {
            flex: 1;
        }

        footer {
            width: 100%;
            background-color: #3A6D8C;
            color: white;
            text-align: center;
            padding: 0.7rem 0;
            position: sticky;
            bottom: 0;
            left: 0;
        }

        footer a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Pet Management</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Breed</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Health</th>
                <th>Adoption Fee</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pets as $pet): ?>
                <tr>
                    <td><?php echo $pet['id']; ?></td>
                    <td><?php echo $pet['name']; ?></td>
                    <td><?php echo $pet['breed']; ?></td>
                    <td><?php echo $pet['gender']; ?></td>
                    <td><?php echo $pet['age']; ?></td>
                    <td><?php echo $pet['health']; ?></td>
                    <td><?php echo $pet['adoption_fee']; ?></td>
                    <td><?php echo $pet['available'] == 1 ? 'Yes' : 'No'; ?></td>
                    <td>
                        <a href="edit_pet.php?id=<?php echo $pet['id']; ?>" class="btn btn-success btn-sm">Update</a>
                        <a href="delete_pet.php?id=<?php echo $pet['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<footer>
    <div class="text-center p-2">
        © 2025 Copyright:
        <a class="text-white" href="#"> <strong>Petfinder</strong></a>
    </div>
</footer>
</body>
</html>
