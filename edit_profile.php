<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error_message = ""; // Initialize error message
$success_message = ""; // Optional success message

// Fetch user data for the form
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = :id";
$query = $pdo->prepare($sql);
$query->bindParam(':id', $user_id, PDO::PARAM_INT);
$query->execute();
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $error_message = "User not found.";
}

// Handle form submission
if (isset($_POST['update'])) {
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
            $success_message = "Profile updated successfully!";
        } else {
            $error_message = "Passwords do not match!";
        }
    } else {
        $success_message = "Profile updated successfully!";
    }
}
?>
