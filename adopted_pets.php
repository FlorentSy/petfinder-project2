<?php
session_start();
require 'config.php';
require 'header.php';  // Add this if you have a header file

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT 
        pets.*, 
        adopted_pets.adopt_date 
    FROM pets
    JOIN adopted_pets ON pets.id = adopted_pets.pet_id
    WHERE adopted_pets.user_id = ?
    ORDER BY adopted_pets.adopt_date DESC
");
$stmt->execute([$user_id]);
$adopted_pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <h1 class="mb-4">Your Adopted Pets</h1>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            Pet adoption successful!
        </div>
    <?php endif; ?>

    <?php if (empty($adopted_pets)): ?>
        <div class="alert alert-info">
            <p class="mb-0">You haven't adopted any pets yet. <a href="index.php">Browse available pets</a></p>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($adopted_pets as $pet): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= htmlspecialchars($pet['image'] ?? 'images/default-pet.jpg') ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($pet['name']) ?>"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($pet['name']) ?></h5>
                            <p class="card-text">
                                <small class="text-muted">
                                    <?= htmlspecialchars($pet['breed']) ?> • 
                                    <?= htmlspecialchars($pet['age']) ?> years
                                </small>
                            </p>
                            <p class="card-text">
                                <?= htmlspecialchars(substr($pet['description'] ?? 'No description available', 0, 100)) ?>...
                            </p>
                            <p class="card-text">
                                <small class="text-muted">
                                    Adopted on: <?= date('F j, Y', strtotime($pet['adopt_date'])) ?>
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require 'footer.php'; // Add this if you have a footer file ?>