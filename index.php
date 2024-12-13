<?php
require 'config.php';
require 'utils.php';
require 'header.php';

// Pagination settings
$items_per_page = 9;
$page = isset($_GET['page']) ? (int)sanitizeInput($_GET['page']) : 1;
$offset = ($page - 1) * $items_per_page;

// Handle search, filters and sorting
$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$breed_filter = isset($_GET['breed']) ? sanitizeInput($_GET['breed']) : '';
$age_filter = isset($_GET['age']) ? sanitizeInput($_GET['age']) : '';
$sort = isset($_GET['sort']) ? sanitizeInput($_GET['sort']) : 'newest';

// Build the query with filters
$query = "SELECT SQL_CALC_FOUND_ROWS * FROM pets WHERE available = 1";
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

// Add sorting
switch ($sort) {
    case 'age_asc':
        $query .= " ORDER BY age ASC";
        break;
    case 'age_desc':
        $query .= " ORDER BY age DESC";
        break;
    case 'name_asc':
        $query .= " ORDER BY name ASC";
        break;
    case 'oldest':
        $query .= " ORDER BY created_at ASC";
        break;
    case 'newest':
    default:
        $query .= " ORDER BY created_at DESC";
        break;
}

// Add pagination
$query .= " LIMIT ? OFFSET ?";
$params[] = $items_per_page;
$params[] = $offset;

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get total count for pagination
$total_count = $pdo->query("SELECT FOUND_ROWS()")->fetchColumn();
$total_pages = ceil($total_count / $items_per_page);

// Get unique breeds for filter
$breed_stmt = $pdo->query("SELECT DISTINCT breed FROM pets WHERE available = 1");
$breeds = $breed_stmt->fetchAll(PDO::FETCH_COLUMN);

// Get user favorites if logged in
$favorites = [];
if (isset($_SESSION['user_id'])) {
    $fav_stmt = $pdo->prepare("SELECT pet_id FROM favorites WHERE user_id = ?");
    $fav_stmt->execute([$_SESSION['user_id']]);
    $favorites = $fav_stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Find your perfect pet companion. Browse our selection of dogs, cats, and other pets available for adoption.">
    <meta name="keywords" content="pet adoption, adopt pets, dogs, cats, pet shelter">
    <title>Pet Adoption - Find Your Perfect Companion</title>
    
    <meta property="og:title" content="Pet Adoption - Find Your Perfect Companion">
    <meta property="og:description" content="Browse our selection of pets available for adoption">
    <meta property="og:image" content="/images/pets-hero.jpg">
    
    <link rel="preload" as="image" href="/images/pets-hero.jpg">
</head>
<body>

<nav aria-label="breadcrumb" class="container mt-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Available Pets</li>
    </ol>
</nav>

<div class="hero-section position-relative mb-5">
    <div class="hero-image w-100" 
             role="img" 
             aria-label="Happy pets background image">
        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
            <h1 class="display-4 fw-bold mb-4">Find Your Perfect Companion</h1>
            <p class="lead mb-4">Every pet deserves a loving home. Start your journey here.</p>
            <a href="#available-pets" class="pets1-button">View Available Pets</a>
        </div>
    </div>
</div>

<section class="container my-5" aria-label="Pet categories">
    <div class="row">
        <div class="col-md-4">
            <a href="dogs.php" class="category-box">
                <i class="category-icon" role="img" aria-label="Dog icon">🐶</i>
                <h3>Dogs</h3>
                <p>Find loyal companions</p>
            </a>
        </div>
        <div class="col-md-4">
            <a href="cats.php" class="category-box">
                <i class="category-icon" role="img" aria-label="Cat icon">🐱</i>
                <h3>Cats</h3>
                <p>Meet furry friends</p>
            </a>
        </div>
        <div class="col-md-4">
            <a href="other-pets.php" class="category-box">
                <i class="category-icon" role="img" aria-label="Paw print icon">🐾</i>
                <h3>Other Pets</h3>
                <p>Discover unique companions</p>
            </a>
        </div>
    </div>
</section>

<section class="container mb-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3" id="filter-form">
                <div class="col-md-4">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Search pets..." 
                           value="<?php echo htmlspecialchars($search); ?>"
                           aria-label="Search pets">
                </div>
                <div class="col-md-2">
                    <select name="breed" class="form-select" aria-label="Filter by breed">
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
                    <select name="age" class="form-select" aria-label="Filter by age">
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
                    <select name="sort" class="form-select" aria-label="Sort results">
                        <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                        <option value="oldest" <?php echo $sort === 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                        <option value="age_asc" <?php echo $sort === 'age_asc' ? 'selected' : ''; ?>>Age (Youngest)</option>
                        <option value="age_desc" <?php echo $sort === 'age_desc' ? 'selected' : ''; ?>>Age (Oldest)</option>
                        <option value="name_asc" <?php echo $sort === 'name_asc' ? 'selected' : ''; ?>>Name (A-Z)</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit