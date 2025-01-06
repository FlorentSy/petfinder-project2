<?php
require 'config.php';
include_once 'header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $sql = "UPDATE users SET name = :name, surname = :surname, username = :username, email = :email, is_admin = :is_admin WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':name', $name);
    $query->bindParam(':surname', $surname);
    $query->bindParam(':username', $username);
    $query->bindParam(':email', $email);
    $query->bindParam(':is_admin', $is_admin, PDO::PARAM_INT);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Update User</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Update User</h2>
    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo $user['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="surname" class="form-label">Surname</label>
            <input type="text" id="surname" name="surname" class="form-control" value="<?php echo $user['surname']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="<?php echo $user['username']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="is_admin" name="is_admin" <?php echo $user['is_admin'] == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label" for="is_admin">Admin</label>
        </div>
        <button type="submit" name="update" class="btn btn-success mt-3">Update</button>
    </form>
</div>
</body>
</html>
