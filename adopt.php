<?php
require 'config.php';
session_start();

$success = false;
$error_message = '';
$petName = '';

// Input validation
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  $error_message = 'Invalid pet ID provided';
} else {
  $petId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  try {
    // Start transaction
    $pdo->beginTransaction();

    // Check if pet exists and is available
    $stmt = $pdo->prepare("SELECT name, available, category FROM pets WHERE id = ?");
    $stmt->execute([$petId]);
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pet) {
      throw new Exception('Pet not found');
    }

    if (!$pet['available']) {
      throw new Exception('Sorry, this pet has already been adopted');
    }

    // Mark pet as unavailable
    $updateStmt = $pdo->prepare("UPDATE pets SET available = 0, adoption_date = NOW() WHERE id = ?");
    $updateStmt->execute([$petId]);

    // Commit transaction
    $pdo->commit();

    $success = true;
    $petName = htmlspecialchars($pet['name']);
    $category = $pet['category'];

  } catch (Exception $e) {
    $pdo->rollBack();
    $error_message = $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $success ? 'Adoption Successful!' : 'Error'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #3B3030;
            --hover-color: #795757;
            --success-color: #4CAF50;
            --error-color: #f44336;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #f4f4f4 0%, #e0e0e0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }

        .success-icon {
            font-size: 48px;
            color: var(--success-color);
            margin-bottom: 20px;
        }

        .error-icon {
            font-size: 48px;
            color: var(--error-color);
            margin-bottom: 20px;
        }

        h1 {
            color: var(--primary-color);
            margin: 0 0 20px 0;
            font-size: 2em;
        }

        p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .button {
            display: inline-block;
            text-decoration: none;
            background-color: var(--primary-color);
            color: white;
            font-size: 16px;
            padding: 12px 24px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .button:hover {
            background-color: var(--hover-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .button:active {
            transform: translateY(0);
        }

        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }
            
            h1 {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
<div class="container animate__animated animate__fadeIn">
    <?php if ($success): ?>
      <div class="success-icon">✓</div>
      <h1>Congratulations!</h1>
      <p>You've successfully adopted <?php echo $petName; ?>! Thank you for giving them a forever home. We'll be in touch shortly with next steps.</p>
      <div class="buttons">
      <a href="index.php" class="button">Back to Home</a>
      <a href="<?php echo ($category === 'dog') ? 'dogs.php' : (($category === 'cat') ? 'cats.php' : 'otherpets.php'); ?>" class="button">Back to <?php echo ucfirst($category); ?></a>

      </div>
    <?php else: ?>
      <div class="error-icon">❌</div>
      <h1 style="color: var(--error-color);">Oops! Something went wrong</h1>
      <p><?php echo htmlspecialchars($error_message); ?></p>
      <a href="index.php" class="button">Back to Home</a>
    <?php endif; ?>
  </div>
</body>
</html>
