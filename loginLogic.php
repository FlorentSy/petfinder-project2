<?php
session_start();
require 'config.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo "All fields are required!";
        header("refresh:2; url=login.php");
        exit;
    }

    $sql = "SELECT * FROM users WHERE username = :username";
    $query = $pdo->prepare($sql);
    $query->bindParam(':username', $username);
    $query->execute();

    if ($query->rowCount() > 0) {
        $user = $query->fetch();
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to index.php
            header("Location: index.php");
            exit;
        } else {
            echo "Incorrect password!";
            header("refresh:2; url=login.php");
            exit;
        }
    } else {
        echo "User not found!";
        header("refresh:2; url=login.php");
        exit;
    }
}
?>