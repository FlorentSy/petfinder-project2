<?php
require 'config.php';
require 'utils.php';
require 'header.php';

$category = isset($_GET['category']) ? sanitizeInput($_GET['category']) : '';

// Build the query based on category
$query = "SELECT * FROM pets WHERE available = 1";
$params = [];

if ($category === 'dogs') {
    $query .= " AND breed IN (SELECT breed FROM breeds WHERE type = 'dog')";
} elseif ($category === 'cats') {
    $query .= " AND breed IN (SELECT breed FROM breeds WHERE type = 'cat')";
} elseif ($category === 'other') {
    $query .= " AND breed IN (SELECT breed FROM breeds WHERE type = 'other')";
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get unique breeds for filter
$breed_stmt = $pdo->query("SELECT DISTINCT breed FROM pets WHERE available = 1");
$breeds = $breed_stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">
        <?php echo ucfirst($category); ?> Available for Adoption
    </h2>

    <!-- Search and Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search pets...">
                </div>
                <div class="col-md-4">
                    <select name="breed" class="form-select">
                        <option value="">All Breeds</option>
                        <?php foreach ($breeds as $breed): ?>
                            <option value="<?php echo htmlspecialchars($breed); ?>">
                                <?php echo htmlspecialchars($breed); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="filter-btn w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Pets Grid -->
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

<?php require 'footer.php'; ?>