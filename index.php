<?php
require 'config.php';
require 'utils.php';
require 'header.php';

// Handle search and filters
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$breed_filter = isset($_GET['breed']) ? sanitizeInput($_GET['breed']) : '';
$age_filter = isset($_GET['age']) ? sanitizeInput($_GET['age']) : '';

// Build the query with filters
$query = "SELECT * FROM pets WHERE available = 1";
$params = [];

if (!empty($search)) {
    $query .= " AND (name LIKE ? OR breed LIKE ? OR description LIKE ?)";
    $searchTerm = "%$search%";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
}

if (!empty($breed_filter)) {
    $query .= " AND breed = ?";
    $params[] = $breed_filter;
}

if (!empty($age_filter)) {
    $query .= " AND age = ?";
    $params[] = $age_filter;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get unique breeds for filter
$breed_stmt = $pdo->query("SELECT DISTINCT breed FROM pets WHERE available = 1");
$breeds = $breed_stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!-- Hero Section -->
<div class="hero-section position-relative mb-5">
    <div style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1450778869180-41d0601e046e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxfDB8MXxyYW5kb218MHx8cGV0c3x8fHx8fDE2MzY1MjQwMDA&ixlib=rb-1.2.1&q=80&w=1080') center/cover; height: 400px;" 
         class="w-100">
        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
            <h1 class="display-4 fw-bold mb-4">Find Your Perfect Companion</h1>
            <p class="lead mb-4">Every pet deserves a loving home. Start your journey here.</p>
            <a href="#available-pets" class="pets1-button">View Available Pets</a>
        </div>
    </div>
</div>

<!-- Category Boxes -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-4">
            <a href="dogs.php" class="category-box">
                <img class="category-icon" src="dogicon.png" alt="Dog Icon">
                
                <h3>Dogs</h3>
            </a>
        </div>
        <div class="col-md-4">
            <a href="cats.php" class="category-box2">
            <img class="category-icon" src="catlogo3.png" alt="Cat Icon">
                <h3>Cats</h3>
            </a>
        </div>
        <div class="col-md-4">
            <a href="otherpets.php" class="category-box">
                <i class="category-icon">🐾</i>
                <h3>Other Animals</h3>
            </a>
        </div>
    </div>
</div>

<!-- Featured Pets Section (Keep existing, but with 3-4 small boxes) -->
<div class="container" id="available-pets">
    <h2 class="text-center mb-4">Featured Pets</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
        <!-- 3-4 pet boxes -->
    </div>
</div>


<!-- Search and Filters -->
<div class="container mb-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search pets..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-2">
                    <select name="breed" class="form-select">
                        <option value="">All Breeds</option>
                        <?php foreach ($breeds as $breed): ?>
                            <option value="<?php echo htmlspecialchars($breed); ?>"
                                <?php echo $breed_filter === $breed ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($breed); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="age" class="form-select">
                        <option value="">All Ages</option>
                        <?php for($i = 0; $i <= 15; $i++): ?>
                            <option value="<?php echo $i; ?>"
                                <?php echo $age_filter === (string)$i ? 'selected' : ''; ?>>
                                <?php echo $i; ?> years
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="filter-btn">Filter</button>
                </div>
                <div class="col-md-1">
                    <a href="index.php" class="btn btn-secondary w-100 clear-filters-btn">Clear filters</a>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Available Pets Section -->
<div class="container" id="available-pets">
    <h2 class="text-center mb-4">Available Pets</h2>
    
    <?php if (!empty($search) || !empty($breed_filter) || !empty($age_filter)): ?>
        <div class="mb-4 text-center">
            <h5>
                <?php echo count($pets); ?> pets found
                <?php if (!empty($search)): ?>
                    matching "<?php echo htmlspecialchars($search); ?>"
                <?php endif; ?>
            </h5>
            <a href="index.php" class="btn btn-outline-secondary btn-sm">Clear Filters</a>
        </div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
        <?php foreach ($pets as $pet): ?>
            <div class="col">
                <div class="card h-100 shadow-sm hover-shadow transition">
                    <?php if (!empty($pet['image'])): ?>
                        <img src="<?php echo htmlspecialchars($pet['image']); ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($pet['name']); ?>"
                             style="height: 250px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            <?php echo htmlspecialchars($pet['name']); ?>
                            <span class="badge-btn <?php echo strtolower($pet['category']) === 'cat' ? 'cat-badge' : 'dog-badge'; ?>">
                                <?php echo htmlspecialchars($pet['age']); ?> years
                            </span>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($pet['breed']); ?></h6>
                        <p class="card-text"><?php echo htmlspecialchars($pet['description']); ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 text-center" style="margin-bottom: 10px;">
                        <a href="adopt.php?id=<?php echo $pet['id']; ?>" 
                           class="adoptbtn1 <?php echo strtolower($pet['category']) === 'cat' ? 'cat-btn' : 'dog-btn'; ?>">
                           Adopt <?php echo htmlspecialchars($pet['name']); ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($pets)): ?>
        <div class="alert alert-info text-center" role="alert">
            <h4 class="alert-heading">No Pets Found</h4>
            <p>We couldn't find any pets matching your criteria. Try adjusting your filters or check back later!</p>
        </div>
    <?php endif; ?>
</div>



<!-- Call to Action Section -->
<div class="bg-light py-5 mt-5">
    <div class="container text-center">
        <h2 class="mb-4">Want to Help?</h2>
        <p class="lead mb-4">Have a pet that needs a new home? Help us find them their forever family.</p>
        <a href="add_pet.php" class="add-pet-button">Add a Pet</a>
    </div>
</div>

<!-- Add this CSS to your header or stylesheet -->
<style>
.category-icon {
    width: 150px; /* Adjust as needed */
    height: 150px;
    object-fit: contain; /* Ensures the image fits within the given dimensions */
    font-size: 48px;
    margin-bottom: 10px;
}

.category-box {
    display: block;
    background-color: #f1f1f1;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    text-decoration: none;
    color: #333;
    transition: background-color 0.3s;
}

.category-box:hover {
    background-color: #e6e6e6;
}
.category-box2 {
    display: block;
    background-color: #f1f1f1;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    text-decoration: none;
    color: #333;
    transition: background-color 0.3s;
}
.category-box2:hover {
    background-color: #e6e6e6;
}

.pets1-button {
    text-decoration: none;
    color: white;
    background-color: #3F72AF;
    padding: 10px 20px;
    border-radius: 5px;
}

.pets1-button:hover {
    background-color: #3A6D8C;
    color: white;
}

/* Cat styles */
.adoptbtn1.cat-btn {
    text-decoration: none;
    color: white;
    background-color: #7E60BF;
    padding: 10px 25px;
    border-radius: 5px;
    margin-bottom: 10px;
    font-weight: 500;
    font-size: 17px;
}

.badge-btn.cat-badge {
    text-decoration: none;
    color: white;
    background-color: #7E60BF;
    padding: 5px 7px;
    border-radius: 5px;
    margin-bottom: 10px;
    font-size: 14px;
}

/* Dog styles */
.adoptbtn1.dog-btn {
    text-decoration: none;
    color: white;
    background-color: #508D4E;
    padding: 10px 25px;
    border-radius: 5px;
    margin-bottom: 10px;
    font-weight: 500;
    font-size: 17px;
}

.badge-btn.dog-badge {
    text-decoration: none;
    color: white;
    background-color: #80AF81;
    padding: 5px 7px;
    border-radius: 5px;
    margin-bottom: 10px;
    font-size: 14px;
}

/* Hover effects */
.adoptbtn1.cat-btn:hover {
    background-color: rgb(210, 112, 232);
}

.adoptbtn1.dog-btn:hover {
    background-color: #1A5319;
}

.hover-shadow:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease-in-out;
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}

.add-pet-button {
    text-decoration: none;
    color: white;
    background-color: #3A6D8C;
    padding: 20px 30px;
    border-radius: 5px;
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 20px;
}

.add-pet-button:hover {
    background-color: rgb(0, 31, 63);
    color: white;
}

.transition {
    transition: all 0.3s ease-in-out;
}

.hero-section {
    margin-top: -2rem;
}

.filter-container {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 10px;
}

.filter-btn {
    text-decoration: none;
    color: white;
    background-color: #3F72AF;
    padding: 4px 25px;
    border-radius: 5px;
    margin-bottom: 10px;
    border-color: #3F72AF;
}

.filter-btn:hover {
    background-color: rgb(58, 109, 140);
    color: white;
}

.btn {
    max-width: 150px;
    white-space: nowrap;
}

.btn-primary {
    padding-left: 30px;
    padding-right: 30px;
    font-size: 16px;
}

.clear-filters-btn {
    white-space: nowrap;
    font-size: 15px;
    text-align: left;
    padding-left: 10px;
    padding-right: 10px;
}
</style>

<?php require 'footer.php'; ?>