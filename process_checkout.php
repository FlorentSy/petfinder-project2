<?php
session_start();
require 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$pet_id = intval($_POST['pet_id']);
$adoption_fee = floatval($_POST['adoption_fee']);

// Simulate payment processing
$payment_status = 'Completed';

try {
    // Insert checkout record with user_id
    $stmt = $pdo->prepare("
        INSERT INTO checkouts (pet_id, user_id, adoption_fee, payment_status, created_at) 
        VALUES (?, ?, ?, ?, NOW())
    ");
    $stmt->execute([$pet_id, $user_id, $adoption_fee, $payment_status]);

    // Insert into adopted_pets table
    $stmt = $pdo->prepare("INSERT INTO adopted_pets (user_id, pet_id, adopt_date) VALUES (?, ?, NOW())");
    $stmt->execute([$user_id, $pet_id]);

    // Mark the pet as unavailable
    $update = $pdo->prepare("UPDATE pets SET available = 0 WHERE id = ?");
    $update->execute([$pet_id]);

    // Redirect to adopted pets page
    header('Location: adopted_pets.php?success=true');
    exit();
} catch (Exception $e) {
    // Handle error
    echo "An error occurred: " . $e->getMessage();
}
?>
