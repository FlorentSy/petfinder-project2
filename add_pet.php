<?php
// add_pet.php
require 'config.php';
require 'utils.php';
require 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $breed = sanitizeInput($_POST['breed']);
    $age = (int)$_POST['age'];
    $description = sanitizeInput($_POST['description']);
    $image = sanitizeInput($_POST['image']);

    $stmt = $pdo->prepare("INSERT INTO pets (name, breed, age, description, image, available) VALUES (?, ?, ?, ?, ?, 1)");
    $stmt->execute([$name, $breed, $age, $description, $image]);

    // Fetch the newly added pet
    $newPetId = $pdo->lastInsertId();
    $stmt = $pdo->prepare("SELECT * FROM pets WHERE id = ?");
    $stmt->execute([$newPetId]);
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);

    // Display the pet card
    if ($pet) {
        ?>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <?php if (!empty($pet['image'])) : ?>
                            <img src="<?php echo htmlspecialchars($pet['image']); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($pet['name']); ?>"
                                 style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($pet['name']); ?></h5>
                            <p class="card-text">
                                <strong>Breed:</strong> <?php echo htmlspecialchars($pet['breed']); ?><br>
                                <strong>Age:</strong> <?php echo htmlspecialchars($pet['age']); ?> years<br>
                                <strong>Description:</strong> <?php echo htmlspecialchars($pet['description']); ?>
                            </p>
                            <div class="text-center">
                                <a href="index.php" class="btn btn-primary">View All Pets</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        exit(); // Stop execution here to prevent the form from showing again
    }
}
?>

<div class="container mt-4">
    <h2>Add a New Pet</h2>
    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="name" class="form-label">Pet Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="col-md-6">
            <label for="breed" class="form-label">Breed</label>
            <input type="text" class="form-control" id="breed" name="breed" required>
        </div>
        <div class="col-md-6">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control" id="age" name="age" required>
        </div>
        <div class="col-md-6">
            <label for="image" class="form-label">Image URL</label>
            <input type="text" class="form-control" id="image" name="image" value="">
        </div>
        <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Add Pet</button>
        </div>
    </form>
</div>

<?php
require 'footer.php';
?>