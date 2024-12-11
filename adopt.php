<?php
require 'config.php';

if (isset($_GET['id'])) {
    $petId = $_GET['id'];

    // Mark pet as unavailable
    $stmt = $pdo->prepare("UPDATE pets SET available = 0 WHERE id = ?");
    $stmt->execute([$petId]);

    echo "<h1>Thank you for adopting! This pet is now unavailable.</h1>";
    echo "<a href='index.php'>Back to Home</a>";
} else {
    echo "Invalid pet ID.";
}
?>
