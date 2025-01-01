<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM users WHERE id = :id";
$query = $pdo->prepare($sql);
$query->bindParam(':id', $user_id, PDO::PARAM_INT);

if ($query->execute()) {
    // Log the user out after deletion
    session_destroy();
    // Redirect to login page after successful deletion
    header("Location: login.php");
    exit();
} else {
    echo "Error deleting profile.";
}
?>
