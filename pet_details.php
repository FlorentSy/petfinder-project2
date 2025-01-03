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
<div class="row d-flex align-items-stretch"> <div class="col-md-6">
        <div class="pet-image-container"> <?php if (!empty($pet['image'])): ?>
                <img src="<?php echo htmlspecialchars($pet['image']); ?>" 
                     alt="<?php echo htmlspecialchars($pet['name']); ?>"
                     class="img-fluid rounded shadow h-100 w-auto object-fit-cover" style="width: 100%; height: 640px; object-fit: cover;"> <?php endif; ?>
        </div>
    </div>
    <div class="col-md-6 d-flex flex-column"> <div class="pet-details-container flex-grow-1"> <h1 class="mb-3"><?php echo htmlspecialchars($pet['name']); ?></h1>
            <div class="mb-4">
                <span class="badge-btn <?php echo $badgeClass; ?>">
                    <?php echo htmlspecialchars($pet['age']); ?> years
                </span>
                <span class="badge bg-secondary ms-2"><?php echo htmlspecialchars($pet['category']); ?></span>
            </div>
            <h5 class="breed-title">Breed</h5>
            <p class="mb-4"><?php echo htmlspecialchars($pet['breed']); ?></p>
            <h5 class="description-title">About <?php echo htmlspecialchars($pet['name'] ?? ''); ?></h5>
            <p class="mb-4"><?php echo htmlspecialchars($pet['description'] ?? ''); ?></p>
            <div class="pet-characteristics mb-4">
                <h5>Characteristics</h5>
                <div class="characteristics-grid"> <div class="characteristic">
                        <i class="fas fa-paw" style="color:#508D4E"></i> Gender: <?php echo htmlspecialchars($pet['gender'] ?? 'Not specified'); ?>
                    </div>
                    <div class="characteristic">
                        <i class="fas fa-heart" style="color: red;"></i> Health: <?php echo htmlspecialchars($pet['health'] ?? 'Not specified'); ?>
                    </div>
                    <div class="characteristic">
                        <i class="fas fa-home" style="color:#7E60BF"></i> House Trained: <?php echo htmlspecialchars($pet['yes_no'] ?? 'Not specified'); ?>
                    </div>
                    <div class="characteristic">
                    <i class="fa fa-coins" style="color: #FFD43B;"></i> Adoption Fee: 
                        <?php 
                            if (isset($pet['adoption_fee'])) {
                                if ($pet['adoption_fee'] === "Free") {
                                    echo "Free";
                                } elseif (is_numeric($pet['adoption_fee'])) {
                                    echo htmlspecialchars($pet['adoption_fee']) . '€';
                                } else {
                                    echo htmlspecialchars($pet['adoption_fee']);
                                }
                            } else {
                                echo 'Not specified';
                            }
                        ?>
                    </div>

                </div>
            </div>
            <div class="text-center mt-auto"> <a href="adopt_pet.php?id=<?php echo $pet['id']; ?>" class="adoptbtn1 <?php echo $buttonClass; ?>"> Adopt <?php echo htmlspecialchars($pet['name']); ?> </a> </div>
        </div>
      </div>
</div>
</div>
<footer class="footer mt-auto py-3">
    <div class="text-center p-2">
        © 2025 Copyright:
        <a class="text-white" href="#"><strong>Petfinder</strong></a>
    </div>
</footer>
<style>
.row {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Two equal columns */
    align-items: stretch; /* Stretch items to equal height */
}

.pet-image-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 600px; 
    overflow: hidden;
    border-radius: 10px;
    background-color:rgba(245, 245, 245, 0.17);
}
.pet-image-container img {
    height: 400px;
    width: 100%;
    object-fit: cover; 
    border-radius: 10px; 
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
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

/* ... other styles ... */

.pet-characteristics {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.pet-characteristics h5 {
    margin-bottom: 15px; 
}

.characteristics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Responsive columns */
    grid-gap: 10px; /* Spacing between grid items */
}

.characteristic {
    display: flex;
    align-items: center;
    margin-bottom: 5px; 
}

.characteristic i {
    margin-right: 10px;
    color: #666;
    font-size: 1.2em; 
    width: 20px;
    text-align: center; 
}

.adoptbtn1 {
    display: inline-block;
    padding: 15px 40px;
    font-size: 18px;
    font-weight: bold;
    text-transform: uppercase;
    margin-top: 20px;
    text-decoration: none;
    border-radius: 30px;
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
/* General layout settings */
html, body {
    height: 100%; 
    margin: 0; 
    display: flex;
    flex-direction: column;
}

.container {
    flex-grow: 1;
}

/* Footer styles */
footer {
    background-color: #3A6D8C; 
    color: white; 
    text-align: center;
    padding: 0.7rem 0; 
    margin-top: auto; 
}

footer a {
    text-decoration: none; 
    color: white; 
}

footer a:hover {
    text-decoration: underline; 
}
</style>


