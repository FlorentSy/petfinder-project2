<?php
require 'config.php';
require 'utils.php';
require 'header.php';

// Get pet ID from URL
$pet_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch pet details
$stmt = $pdo->prepare("SELECT * FROM pets WHERE id = ? AND available = 1");
$stmt->execute([$pet_id]);
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

// If pet not found, redirect to index
if (!$pet) {
    header('Location: index.php');
    exit();
}

// Determine button class based on pet category
$buttonClass = '';
$badgeClass = '';
switch(strtolower($pet['category'])) {
    case 'cat':
        $buttonClass = 'cat-btn';
        $badgeClass = 'cat-badge';
        break;
    case 'dog':
        $buttonClass = 'dog-btn';
        $badgeClass = 'dog-badge';
        break;
    default:
        $buttonClass = 'others-btn';
        $badgeClass = 'others-badge';
}
?>

<div class="container my-5">
    <div class="row">
        <!-- Pet Image Column -->
        <div class="col-md-6">
            <div class="pet-image-container">
                <?php if (!empty($pet['image'])): ?>
                    <img src="<?php echo htmlspecialchars($pet['image']); ?>" 
                         alt="<?php echo htmlspecialchars($pet['name']); ?>"
                         class="img-fluid rounded shadow">
                <?php endif; ?>
            </div>
        </div>

        <!-- Pet Details Column -->
        <div class="col-md-6">
            <div class="pet-details-container">
                <h1 class="mb-3"><?php echo htmlspecialchars($pet['name']); ?></h1>
                
                <div class="mb-4">
                    <span class="badge-btn <?php echo $badgeClass; ?>">
                        <?php echo htmlspecialchars($pet['age']); ?> years
                    </span>
                    <span class="badge bg-secondary ms-2"><?php echo htmlspecialchars($pet['category']); ?></span>
                </div>

                <h5 class="breed-title">Breed</h5>
                <p class="mb-4"><?php echo htmlspecialchars($pet['breed']); ?></p>

                <h5 class="description-title">About <?php echo htmlspecialchars($pet['name']); ?></h5>
                <p class="mb-4"><?php echo htmlspecialchars($pet['description']); ?></p>

                <!-- Additional Pet Details -->
                <div class="pet-characteristics mb-4">
                    <h5>Characteristics</h5>
                    <div class="row">
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><i class="fas fa-paw"></i> Gender: <?php echo htmlspecialchars($pet['gender'] ?? 'Not specified'); ?></li>
                                <li><i class="fas fa-weight"></i> Size: <?php echo htmlspecialchars($pet['size'] ?? 'Not specified'); ?></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="list-unstyled">
                                <li><i class="fas fa-heart"></i> Temperament: <?php echo htmlspecialchars($pet['temperament'] ?? 'Not specified'); ?></li>
                                <li><i class="fas fa-home"></i> House Trained: <?php echo htmlspecialchars($pet['house_trained'] ?? 'Not specified'); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Adoption Button -->
                <div class="text-center">
                    <a href="adopt.php?id=<?php echo $pet['id']; ?>" 
                       class="adoptbtn1 <?php echo $buttonClass; ?>">
                       Adopt <?php echo htmlspecialchars($pet['name']); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.pet-image-container img {
    width: 100%;
    height: 500px;
    object-fit: cover;
}

.pet-details-container {
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.breed-title, .description-title {
    color: #666;
    margin-bottom: 10px;
}

.pet-characteristics {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.pet-characteristics i {
    margin-right: 10px;
    color: #666;
}

.pet-characteristics li {
    margin-bottom: 10px;
}

.adoptbtn1 {
    display: inline-block;
    padding: 15px 40px;
    font-size: 18px;
    font-weight: bold;
    text-transform: uppercase;
    margin-top: 20px;
    text-decoration: none;
    border-radius: 5px;
}

/* Maintain existing button styles */
.adoptbtn1.cat-btn {
    color: white;
    background-color: #7E60BF;
}

.adoptbtn1.cat-btn:hover {
    background-color: rgb(210, 112, 232);
}

.adoptbtn1.dog-btn {
    color: white;
    background-color: #508D4E;
}

.adoptbtn1.dog-btn:hover {
    background-color: #1A5319;
}

.adoptbtn1.others-btn {
    color: white;
    background-color: #3B3030;
}

.adoptbtn1.others-btn:hover {
    background-color: #795757;
}

/* Badge styles */
.badge-btn {
    padding: 8px 15px;
    font-size: 14px;
    border-radius: 20px;
}

.cat-badge {
    background-color: #7E60BF;
    color: white;
}

.dog-badge {
    background-color: #80AF81;
    color: white;
}

.others-badge {
    background-color: #795757;
    color: white;
}
</style>

<?php require 'footer.php'; ?>