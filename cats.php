<?php
require 'config.php';
require 'utils.php';
require 'header.php';

$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$breed_filter = isset($_GET['breed']) ? sanitizeInput($_GET['breed']) : '';
$gender_filter = isset($_GET['gender']) ? sanitizeInput($_GET['gender']) : '';
$age_filter = isset($_GET['age']) ? sanitizeInput($_GET['age']) : '';
$trained_filter = isset($_GET['yes_no']) ? sanitizeInput($_GET['yes_no']) : '';
$adoption_fee_filter = isset($_GET['adoption_fee']) ? sanitizeInput($_GET['adoption_fee']) : '';

// Build the query with filters
$query = "SELECT * FROM pets WHERE available = 1 AND LOWER(category) = 'cat'";
$params = [];

if (!empty($search)) {
    $query .= " AND (name LIKE ? OR breed LIKE ? OR gender LIKE ? OR age LIKE ? OR yes_no LIKE ? OR adoption_fee LIKE ? OR description LIKE ?)";
    $searchTerm = "%$search%";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
}

if (!empty($breed_filter)) {
    $query .= " AND breed = ?";
    $params[] = $breed_filter;
}

if (!empty($gender_filter)) {
    $query .= " AND gender = ?";
    $params[] = $gender_filter;
}

if (!empty($age_filter)) {
    $query .= " AND age = ?";
    $params[] = $age_filter;
}

if (!empty($trained_filter)) {
    $query .= " AND yes_no = ?";  // CORRECT
    $params[] = $trained_filter;
}

if (!empty($adoption_fee_filter)) {
    $query .= " AND adoption_fee = ?";
    $params[] = $adoption_fee_filter;
}


// Get unique cat breeds for filter
$breed_stmt = $pdo->prepare("SELECT DISTINCT breed FROM pets WHERE available = 1 AND LOWER(category) = 'cat'");
$breed_stmt->execute();
$breeds = $breed_stmt->fetchAll(PDO::FETCH_COLUMN);

// Get unique cat genders for filter
$gender_stmt = $pdo->prepare("SELECT DISTINCT gender FROM pets WHERE available = 1 AND LOWER(category) = 'cat'");
$gender_stmt->execute();
$genders = $gender_stmt->fetchAll(PDO::FETCH_COLUMN);

// Get unique cat ages for filter
$age_stmt = $pdo->prepare("SELECT DISTINCT age FROM pets WHERE available = 1 AND LOWER(category) = 'cat'");
$age_stmt->execute();
$ages = $age_stmt->fetchAll(PDO::FETCH_COLUMN);

// Get unique cat trained status for filter
$trained_stmt = $pdo->prepare("SELECT DISTINCT yes_no FROM pets WHERE available = 1 AND LOWER(category) = 'cat'");
$trained_stmt->execute();
$trained = $trained_stmt->fetchAll(PDO::FETCH_COLUMN);

// Get unique cat adoption fee status for filter
$adoption_fee_stmt = $pdo->prepare("SELECT DISTINCT adoption_fee FROM pets WHERE available = 1 AND LOWER(category) = 'cat'");
$adoption_fee_stmt->execute();
$adoption_fee = $adoption_fee_stmt->fetchAll(PDO::FETCH_COLUMN);


$stmt = $pdo->prepare($query);
$stmt->execute($params);
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get unique breeds for filter
$breed_stmt = $pdo->query("SELECT DISTINCT breed FROM pets WHERE available = 1");
$breeds = $breed_stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!-- Hero Section -->
<div class="hero-section position-relative mb-5">
    <div style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://plus.unsplash.com/premium_photo-1707353402061-c31b6ba8562e?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') center/cover; height: 400px;" 
         class="w-100">
        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
            <h1 class="display-4 fw-bold mb-4">Find Your Perfect Cat Companion</h1>
            <p class="lead mb-4">Give a cat a loving home today. They'll bring joy and warmth to your life..</p>
            <a href="#available-pets" class="pets1-button">
            <img src="cat_pae-removebg-preview.png" alt="" style="width: 100px;">
            View Available Cats
            </a>

        </div>
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
                    <select name="gender" class="form-select">
                        <option value="">All Genders</option>
                        <?php foreach ($genders as $gender): ?>
                            <option value="<?php echo htmlspecialchars($gender); ?>"
                                <?php echo $gender_filter === $gender ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($gender); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <select name="yes_no" class="form-select">
                        <option value="">All Trained Status</option>
                        <?php foreach ($trained as $status): ?>
                            <option value="<?php echo htmlspecialchars($status); ?>"
                                <?php echo $trained_filter === $status ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($status); ?>
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
                <div class="col-md-2">
                    <select name="adoption_fee" class="form-select">
                        <option value="">All Adoption Fees</option>
                        <?php 
                            foreach ($adoption_fee as $fee) {
                                echo '<option value="' . $fee . '">' . $fee . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="filter-btn">Filter</button>
                </div>
                <div class="col-md-1">
                    <a href="cats.php" class="btn btn-secondary w-100 clear-filters-btn ">Clear filters</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Available Pets Section -->
<div class="container" id="available-pets">
    <h2 class="text-center mb-4">Available Cats</h2>
    
    <?php if (!empty($search) || !empty($breed_filter) || !empty($gender_filter) || !empty($trained_filter) || !empty($adoption_fee_filter) || !empty($age_filter)): ?>
        <div class="mb-4 text-center">
            <h5>
                <?php echo count($pets); ?> pets found
                <?php if (!empty($search)): ?>
                    matching "<?php echo htmlspecialchars($search); ?>"
                <?php endif; ?>
            </h5>
            <a href="cats.php" class="btn btn-outline-secondary btn-sm">Clear Filters</a>
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
                            <span class="badge-btn"><?php echo htmlspecialchars($pet['age']); ?> years</span>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($pet['breed']); ?></h6>
                        <h6 class="card-subtitle mb-2 text-muted"> <?php echo htmlspecialchars($pet['gender']); ?></h6>
                        <h6 class="card-subtitle mb-2 text-muted"> 
                            <?php 
                               if (isset($pet['adoption_fee'])) {
                                // Explicitly check for the string "free"
                                if (strtolower(trim($pet['adoption_fee'])) === "free") {
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
                        </h6>

                        <p class="card-text"><?php echo htmlspecialchars($pet['description'] ?? ''); ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 text-center " style="margin-bottom: 10px;;">
                        <a href="pet_details.php?id=<?php echo $pet['id']; ?>" 
                           class="adoptbtn1">Adopt <strong><?php echo htmlspecialchars($pet['name']); ?></strong></a>
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

<style>
.pets1-button{
    text-decoration: none;
    color: white;
    background-color: #7E60BF;
    padding: 10px 20px;
    border-radius: 5px;
}

.pets1-button:hover{
    background-color: rgb(210, 112, 232);
    color: white;
}
.adoptbtn1{
    text-decoration: none;
    color: white;
    background-color: #7E60BF;
    padding: 10px 25px;
    border-radius: 20px;
    margin-bottom: 10px;
    font-weight: 500;
    font-size: 17px;
}

.adoptbtn1:hover {
    background-color: rgb(210, 112, 232);
}


.hover-shadow:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease-in-out;
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
.badge-btn{
    text-decoration: none;
    color: white;
    background-color:rgba(126, 96, 191, 0.8);;
    padding: 5px 7px;
    border-radius: 5px;
    margin-bottom: 10px;
    font-size: 14px;
}
.badge-btn:hover{
    background-color: rgb(210, 112, 232);
}
.add-pet-button{
    text-decoration: none;
    color: white;
    background-color: #7E60BF;
    padding: 20px 30px;
    border-radius: 5px;
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 20px;
}
.add-pet-button:hover{
    background-color: rgb(210, 112, 232);
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
.filter-btn{
    text-decoration: none;
    color: white;
    background-color: #7E60BF;
    padding: 4px 25px;
    border-radius: 5px;
    margin-bottom: 10px;
    border-color: #7E60BF;
}
.filter-btn:hover{
    background-color: rgb(210, 112, 232);
    color: white;
    border-color: rgb(210, 112, 232);
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