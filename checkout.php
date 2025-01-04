<?php
require 'config.php';
require 'utils.php';
require 'header.php';

$pet_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$adoption_fee = isset($_GET['fee']) ? floatval($_GET['fee']) : 0.0;

// Fetch pet details for confirmation
$stmt = $pdo->prepare("SELECT name, image FROM pets WHERE id = ?");
$stmt->execute([$pet_id]);
$pet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pet) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption Checkout</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <style>
        /* General styles */
        * {
            margin: 0;
            padding: 0;
            outline: none;
            text-decoration: none;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .checkout-container {
            width: 96%;
            max-width: 1000px;
            height: 600px;
            position: absolute;
            top: 62%; 
            left: 50%;
            transform: translate(-50%, -60%);
            border-radius: 5px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            background-color: #f5f5f5;
        }

        /* Product Section */
        .product-section {
            width: 50%;
            padding: 20px;
            position: relative;
            background-color: white;
        }

        .product-image img {
            width: 100%;
            border-radius: 8px;
            margin-top: 55px;
        }

        .product-details {
            text-align: center;
            margin-top: 15px;
        }

        .product-details h1 {
            font-size: 1.8rem;
            color: #333;
        }

        .product-details p {
            font-size: 1rem;
            color: #666;
        }

        /* Payment Section */
        .payment-section {
            width: 60%;
            padding: 20px;
            background-color: #f5f5f5;
            border-left: 2px solid #eee;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .payment-section h2 {
            font-size: 1.5rem;
            color: #3A6D8C;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 1rem;
            color: #555;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .payment-btn {
            width: 100%;
            padding: 15px;
            font-size: 1rem;
            color: white;
            background-color: #508D4E;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .payment-btn:hover {
            background-color: #1A5319;
        }
    </style>
</head>
<body>
<div class="checkout-container">
    <!-- Product Section -->
    <div class="product-section">
        <div class="product-image">
            <img src="<?= htmlspecialchars($pet['image']); ?>" alt="<?= htmlspecialchars($pet['name']); ?>">
        </div>
        <div class="product-details">
            <h1><?= htmlspecialchars($pet['name']); ?></h1>
            <p>Adoption Fee: <strong><?= number_format($adoption_fee, 2); ?> €</strong></p>
        </div>
    </div>

    <!-- Payment Section -->
    <div class="payment-section">
        <h2>Payment Information</h2>
        <form id="checkoutForm" action="process_checkout.php" method="POST">
            <input type="hidden" name="pet_id" value="<?= $pet_id; ?>">
            <input type="hidden" name="adoption_fee" value="<?= $adoption_fee; ?>">

            <div class="form-group">
                <label for="cardNumber">Card Holder</label>
                <input type="text" id="cardHolder" name="cardHolder" maxlength="40" placeholder="ex: John Doe" style="text-transform: uppercase;" required >
            </div>
            
            <div class="form-group">
                <label for="cardNumber">Card Number</label>
                <input type="text" id="cardNumber" name="cardNumber" maxlength="19" placeholder="1234 5678 9012 3456" required>
            </div>

            <div class="form-group">
                <label for="expiryDate">Expiry Date</label>
                <input type="text" id="expiryDate" name="expiryDate" maxlength="5" placeholder="MM/YY" required>
            </div>

            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" maxlength="3" placeholder="123" required>
            </div>

            <button type="submit" class="payment-btn">Pay and Adopt</button>
        </form>
    </div>
</div>

<script>
    // Automatically format card number
    document.getElementById('cardNumber').addEventListener('input', function (e) {
        const input = e.target.value.replace(/\D/g, '');
        const formatted = input.match(/.{1,4}/g)?.join(' ') || input;
        e.target.value = formatted;
    });

    // Automatically format expiry date
    document.getElementById('expiryDate').addEventListener('input', function (e) {
        const input = e.target.value.replace(/\D/g, '');
        const formatted = input.length > 2 ? input.slice(0, 2) + '/' + input.slice(2) : input;
        e.target.value = formatted;
    });

    // Basic validation on form submission
    document.getElementById('checkoutForm').addEventListener('submit', function (e) {
        const cardNumber = document.getElementById('cardNumber').value;
        const expiryDate = document.getElementById('expiryDate').value;
        const cvv = document.getElementById('cvv').value;

        if (cardNumber.length !== 19 || expiryDate.length !== 5 || cvv.length !== 3) {
            e.preventDefault();
            alert('Please enter valid payment details.');
        }
    });
</script>
</body>
</html>
