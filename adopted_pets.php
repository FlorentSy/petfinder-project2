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

<footer>
<div class="text-center p-2">
        © 2025 Copyright:
        <a class="text-white" href="#"><strong>Petfinder</strong></a>
    </div>
</footer>
<style>
  html, body {
    height: 100%; /* Make sure the html and body cover the full height of the viewport */
    margin: 0; /* Remove default margin */
    display: flex;
    flex-direction: column; /* Organizes content in a column */
}

body {
    flex: 1; /* Allows the body to expand to fill available space */
}

footer {
    width: 100%; /* Ensures the footer stretches across the full width of the viewport */
    background-color: #3A6D8C; /* Background color */
    color: white; /* Text color */
    text-align: center; /* Centers the text */
    padding: 0.8rem 0; /* Padding above and below the content */
    position: absolute;
    bottom: 0; /* Sticks to the bottom */
    left: 0; /* Aligns to the left edge */
}
footer a {
        text-decoration: none;
        color: white; /* Ensure text color is white or another color based on your design */
    }
</style>