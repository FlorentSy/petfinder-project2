<?php
// add_pet.php
require 'config.php';
require 'utils.php';
require 'header.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Required fields validation
        $required_fields = ['name', 'breed', 'gender', 'yes_no', 'age', 'category'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("$field is required");
            }
        }

        // Sanitize and validate input
        $name = sanitizeInput($_POST['name']);
        $breed = sanitizeInput($_POST['breed']);
        $gender = sanitizeInput($_POST['gender']);
        $trained = sanitizeInput($_POST['yes_no']);
        $health = sanitizeInput($_POST['health']);
        $adoption_fee = sanitizeInput($_POST['adoption_fee']);


        $age = filter_var($_POST['age'], FILTER_VALIDATE_INT);
        
        // Optional fields
        $description = !empty($_POST['description']) ? sanitizeInput($_POST['description']) : null;
        $image = !empty($_POST['image']) ? sanitizeInput($_POST['image']) : null;
        $category = strtolower(sanitizeInput($_POST['category']));

        // Validate age
        if ($age === false || $age < 0) {
            throw new Exception("Invalid age value");
        }

        // Use PDO prepared statement with named parameters
        $stmt = $pdo->prepare("
            INSERT INTO pets (name, breed, gender, age, yes_no, health, adoption_fee, description, image, category) 
            VALUES (:name, :breed, :gender, :age, :yes_no, :health, :adoption_fee, :description, :image, :category)
        ");

        $params = [
            ':name' => $name,
            ':breed' => $breed,
            ':gender' => $gender,
            ':age' => $age,
            ':yes_no' => $trained,
            ':health' => $health,
            ':adoption_fee' => $adoption_fee,
            ':description' => $description,
            ':image' => $image,
            ':category' => $category
        ];
        
        // Execute the statement
        $result = $stmt->execute($params);

        // Only fetch and display the pet if insertion was successful
        if ($stmt->rowCount() > 0) {
            // Fetch the newly added pet
            $newPetId = $pdo->lastInsertId();
            $stmt = $pdo->prepare("SELECT * FROM pets WHERE id = ?");
            $stmt->execute([$newPetId]);
            $pet = $stmt->fetch(PDO::FETCH_ASSOC);

            // Only display if pet was successfully fetched
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
                                        <span><strong>Breed:</strong> <?php echo htmlspecialchars($pet['breed']); ?></span> <br>
                                        <span><strong>Gender:</strong> <?php echo htmlspecialchars($pet['gender']); ?></span> <br>
                                        <span><strong>Age:</strong> <?php echo htmlspecialchars($pet['age']); ?> years</span> <br>
                                        <span><strong>Adoption Fee:</strong> <?php 
                                            if($pet['adoption_fee'] == 0 || strtolower($pet['adoption_fee']) == 'free') {
                                                echo 'Free';
                                            } else {
                                                echo htmlspecialchars($pet['adoption_fee']) . ' €';
                                            }
                                        ?>
                                        </span> <br>
                                        <span><strong>Trained:</strong> <?php echo htmlspecialchars($pet['yes_no']); ?></span> <br>
                                        <span><strong>Adoption Fee:</strong> <?php echo htmlspecialchars($pet['adoption_fee']); ?></span> <br>
                                        <span><strong>Health:</strong> <?php echo htmlspecialchars($pet['health']); ?></span> <br>
                                    </p>
                                    <div class="text-center">
                                        <?php 
                                        $redirectPage = match(strtolower($pet['category'])) {
                                            'cat' => 'cats.php',
                                            'dog' => 'dogs.php',
                                            'others' => 'otherpets.php',
                                            default => 'index.php',
                                        };
                                        ?>
                                        <a href="<?php echo $redirectPage; ?>" 
                                           style="background-color: #3A6D8C; color: white; padding: 10px 20px; border: 2px solid #3A6D8C; border-radius: 8px; text-decoration: none; display: inline-block;" 
                                           class="btn">
                                            View <?php echo htmlspecialchars($pet['category']); ?>s
                                        </a>
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
        $message = "Pet added successfully!";
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        $message = "Database error occurred. Please try again later.";
    } catch (Exception $e) {
        error_log("Validation Error: " . $e->getMessage());
        $message = $e->getMessage();
    }
}
?>

<div class="container mt-4">
    <?php if (!empty($message)): ?>
        <div class="alert <?php echo strpos($message, 'error') !== false ? 'alert-danger' : 'alert-success'; ?>" role="alert">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

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
        <div class="col-md-4">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
                <option value="">Select Category</option>
                <option value="dog">Dog</option>
                <option value="cat">Cat</option>
                <option value="others">Others</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select" id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control" id="age" name="age" min="0"  required>
        </div>
     
        <div class="col-md-4">
            <label for="yes_no" class="form-label">House Trained</label>
            <select class="form-select" id="yes_no" name="yes_no" required>
                <option value="">Select an option</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="health" class="form-label">Health Information</label>
            <input type="text" class="form-control" id="health" name="health" placeholder="Enter Health Information/Vaccinations" required>
        </div>
        <div class="col-md-4">
            <label for="adoption_fee" class="form-label">Adoption Fee</label>
            <input type="text" class="form-control" id="adoption_fee" name="adoption_fee" pattern="^\d+$|^free$" required>
            <small class="form-text text-muted">Enter a numeric value only (e.g., 50) or type "free" to indicate no fee.</small>
        </div>

        <div class="col-md-4">
            <label for="image" class="form-label">Pet Image</label>
            <input type="file" accept="image/*" class="form-control" id="image" name="image">
            <small class="form-text text-muted">Accepted formats: JPG, PNG, GIF, WebP</small>
            <p id="error" style="color: red; display: none;">Please select a valid image file!</p>
        </div>
        <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="addpetbtn">Add Pet</button>
        </div>
    </form>
</div>

<script>
  const imageUpload = document.getElementById('image');
  const error = document.getElementById('error');

  imageUpload.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
      const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
      if (validImageTypes.includes(file.type)) {
        error.style.display = 'none'; // Hide error if valid image
        console.log('Valid image file selected:', file.name);
      } else {
        error.style.display = 'block'; // Show error if invalid file
        imageUpload.value = ''; // Clear the input field
      }
    }
  });

</script>

<style>
    .card-text {
        display: flex;
        flex-wrap: wrap;
        gap: 15px; /* Adjust spacing between items */
    }

    .card-text span {
        display: inline-block;
    }
    .btn:hover {
        background-color: black !important;
        color: #fff !important;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .addpetbtn {
        text-decoration: none;
        color: white;
        background-color: #3A6D8C;
        padding: 10px 20px;
        border-radius: 5px;
        border-color: white;
    }
    .addpetbtn:hover {
        background-color: #6A9AB0;
        color: white;
    }
</style>
<!-- 
<script>
    document.getElementById('adoption_fee').addEventListener('input', function() {
        var input = this.value;
        if (input.toLowerCase() === 'free') {
            this.value = 'Free';  // Capitalize "free" as "Free"
        }
    });
</script> -->

<?php require 'footer.php'; ?>