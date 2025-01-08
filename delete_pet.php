<?php
include 'config.php'; // Include the database connection file

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Prepare the DELETE statement
        $sql = "DELETE FROM pets WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            header('Location: dashboard.php');
            exit;
        } else {
            echo "Error: Unable to delete the pet.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
