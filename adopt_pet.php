<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$pet_id = intval($_GET['id']);

try {
    // Start transaction
    $pdo->beginTransaction();

    // Check if pet is available
    $check_stmt = $pdo->prepare("SELECT id, name, category FROM pets WHERE id = ? AND available = 1");
    $check_stmt->execute([$pet_id]);
    $pet = $check_stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$pet) {
        throw new Exception("Pet is not available for adoption.");
    }

    // Check if user has already adopted this pet
    $check_adoption = $pdo->prepare("SELECT id FROM adopted_pets WHERE user_id = ? AND pet_id = ?");
    $check_adoption->execute([$user_id, $pet_id]);
    if ($check_adoption->fetch()) {
        throw new Exception("You have already adopted this pet.");
    }

    // Insert into adopted_pets
    $adopt_stmt = $pdo->prepare("INSERT INTO adopted_pets (user_id, pet_id, adopt_date) VALUES (?, ?, NOW())");
    $adopt_stmt->execute([$user_id, $pet_id]);

    // Update pet availability
    $update_stmt = $pdo->prepare("UPDATE pets SET available = 0 WHERE id = ?");
    $update_stmt->execute([$pet_id]);

    // Commit transaction
    $pdo->commit();
    
    // Redirect to adopted pets page
    header('Location: adopted_pets.php?success=1');
    exit();

} catch (Exception $e) {
    // Rollback on error
    $pdo->rollBack();
    header('Location: pet_details.php?id=' . $pet_id . '&error=' . urlencode($e->getMessage()));
    exit();
}
?>