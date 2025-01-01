<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update'])) {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Update basic profile information
    $sql = "UPDATE users SET name = :name, surname = :surname, username = :username, email = :email WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':name', $name);
    $query->bindParam(':surname', $surname);
    $query->bindParam(':username', $username);
    $query->bindParam(':email', $email);
    $query->bindParam(':id', $user_id, PDO::PARAM_INT);
    $query->execute();

    // Update password if provided and confirmed
    if (!empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = :password WHERE id = :id";
            $query = $pdo->prepare($sql);
            $query->bindParam(':password', $hashed_password);
            $query->bindParam(':id', $user_id, PDO::PARAM_INT);
            $query->execute();
        } else {
            echo "Passwords do not match!";
            exit();
        }
    }

    // Redirect to home page after successful update
    header("Location: index.php");
    exit();
}
?>
