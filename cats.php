<?php
require 'config.php';
require 'utils.php';
require 'header.php';

$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$breed_filter = isset($_GET['breed']) ? sanitizeInput($_GET['breed']) : '';
$age_filter = isset($_GET['age']) ? sanitizeInput($_GET['age']) : '';

// Build the query with filters
$query = "SELECT * FROM pets WHERE available = 1 AND LOWER(category) = 'cat'";
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

// Get unique cat breeds for filter
$breed_stmt = $pdo->prepare("SELECT DISTINCT breed FROM pets WHERE available = 1 AND LOWER(category) = 'cat'");
$breed_stmt->execute();
$breeds = $breed_stmt->fetchAll(PDO::FETCH_COLUMN);


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
                    <a href="index.php" class="btn btn-secondary w-100 clear-filters-btn ">Clear filters</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Available Pets Section -->
<div class="container" id="available-pets">
    <h2 class="text-center mb-4">Available Cats</h2>
    
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
                            <span class="badge-btn"><?php echo htmlspecialchars($pet['age']); ?> years</span>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($pet['breed']); ?></h6>
                        <p class="card-text"><?php echo htmlspecialchars($pet['description']); ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 text-center " style="margin-bottom: 10px;;">
                        <a href="adopt.php?id=<?php echo $pet['id']; ?>" 
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

<!-- Add this CSS to your header or stylesheet -->
<style>
    .card-text{
        font-size:15px ;
    }
    .pets1-button {
      display: inline-block;
      text-align: center;
      text-decoration: none;
      color: white;
      font-weight:bold;
      font-size: 14px;
      background-color:rgb(106, 79, 163);
      border-radius: 50%;
      width: 145px;
      height: 145px;
      position: relative;
      transition: background-color 0.3s ease;
      
    }

    .pets1-button:hover {
      background-color: rgb(210, 112, 232);
    }

    .pets1-button img {
      border-radius: 50%;
      margin: 10px;
      margin-top: 15px;
    }

    #available-pets {
      margin-top: 20px;
      text-align: center;
      font-size: 24px;
    }
    
.adoptbtn1{
    text-decoration: none;
    color: white;
    background-color: #7E60BF;
    padding: 10px 25px;
    border-radius: 5px;
    margin-bottom: 10px;
    font-weight: 500;
    font-size: 17px;
}

.hover-shadow:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease-in-out;
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
.badge-btn{
    text-decoration: none;
    color: white;
    background-color: #7E60BF;
    padding: 5px 7px;
    border-radius: 5px;
    margin-bottom: 10px;
    font-size: 14px;
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
    margin-top: -2rem; /* Adjust based on your header height */
}
/* Make sure the parent container uses flex */
.filter-container {
    display: flex;
    align-items: center;
    justify-content: flex-start; /* Adjust this as needed */
    gap: 10px; /* Adds spacing between buttons */
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
    max-width: 150px; /* Set a max width for the button */
    white-space: nowrap; /* Prevent text from wrapping */
}

.btn-primary {
    padding-left: 30px; /* Adds space to the left */
    padding-right: 30px; /* Adds space to the right */
    font-size: 16px; /* Optional: Adjust the font size to better fit the button */
}



.clear-filters-btn {
    white-space: nowrap; /* Ensures the text doesn't wrap */
    font-size: 15px;
    text-align: left; /* Align text to the left */
    padding-left: 10px; /* Optional: adjust padding to ensure there's space on the left */
    padding-right: 10px; /* Optional: adjust padding to control button's width */
}


</style>

<?php require 'footer.php'; ?>