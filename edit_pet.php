<?php
session_start();
require 'config.php';
include_once 'header.php';

// Ensure only admins can access this page
if ($_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

$error_message = ""; // Initialize error message
$success_message = ""; // Optional success message

// Fetch pet data for the form
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM pets WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $pet = $query->fetch(PDO::FETCH_ASSOC);

    if (!$pet) {
        $error_message = "Pet not found.";
    }
} else {
    $error_message = "Invalid request.";
}

// Handle form submission
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $health = $_POST['health'];
    $adoption_fee = $_POST['adoption_fee'];
    $category = $_POST['category'];
    $available = isset($_POST['available']) ? 1 : 0;

    try {
        $sql = "UPDATE pets SET 
                    name = :name, 
                    breed = :breed, 
                    gender = :gender, 
                    age = :age, 
                    health = :health, 
                    adoption_fee = :adoption_fee, 
                    category = :category, 
                    available = :available 
                WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindParam(':name', $name);
        $query->bindParam(':breed', $breed);
        $query->bindParam(':gender', $gender);
        $query->bindParam(':age', $age);
        $query->bindParam(':health', $health);
        $query->bindParam(':adoption_fee', $adoption_fee);
        $query->bindParam(':category', $category);
        $query->bindParam(':available', $available, PDO::PARAM_INT);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $query->execute();
        $success_message = "Pet details updated successfully!";
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Pet</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Edit Pet Details</h2>

    <!-- Error and Success Messages -->
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($pet['name'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label for="breed" class="form-label">Breed</label>
            <input type="text" class="form-control" id="breed" name="breed" value="<?php echo htmlspecialchars($pet['breed'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select" id="gender" name="gender" required>
                <option value="male" <?php echo ($pet['gender'] ?? '') === 'male' ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo ($pet['gender'] ?? '') === 'female' ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($pet['age'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label for="health" class="form-label">Health</label>
            <textarea class="form-control" id="health" name="health" rows="3" required><?php echo htmlspecialchars($pet['health'] ?? ''); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="adoption_fee" class="form-label">Adoption Fee</label>
            <input type="number" step="0.01" class="form-control" id="adoption_fee" name="adoption_fee" value="<?php echo htmlspecialchars($pet['adoption_fee'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
                <option value="dog" <?php echo ($pet['category'] ?? '') === 'dog' ? 'selected' : ''; ?>>Dog</option>
                <option value="cat" <?php echo ($pet['category'] ?? '') === 'cat' ? 'selected' : ''; ?>>Cat</option>
                <option value="bird" <?php echo ($pet['category'] ?? '') === 'bird' ? 'selected' : ''; ?>>Bird</option>
                <option value="other" <?php echo ($pet['category'] ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="available" name="available" <?php echo ($pet['available'] ?? 0) == 1 ? 'checked' : ''; ?>>
            <label class="form-check-label" for="available">Available</label>
        </div>
        <button type="submit" name="update" class="btn btn-success">Update Pet</button>
    </form>
</div>
</body>
</html>
