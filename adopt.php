<?php
require 'config.php';

if (isset($_GET['id'])) {
    $petId = $_GET['id'];

    // Mark pet as unavailable
    $stmt = $pdo->prepare("UPDATE pets SET available = 0 WHERE id = ?");
    $stmt->execute([$petId]);

    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Adoption Confirmation</title>";
    echo "<style>";
    echo "body { font-family: sans-serif; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; margin: 0; background-color: #f4f4f4; }";
    echo "h1 { color: #333; margin-bottom: 20px; }";
    echo "a { text-decoration: none; background-color: #3B3030; color: white; font-size: 18px; border:1px solid white; padding: 10px 20px; border-radius: 5px; transition: background-color 0.3s ease; }";
    echo "a:hover { background-color: #795757; }";
    echo ".container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); text-align: center;}"; // Added container for better structure
    echo "</style>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>"; // Wrap content in a container
    echo "<h1>Thank you for adopting! This pet is now unavailable.</h1>";
    echo "<a href='index.php'>Back to Home</a>";
    echo "</div>";
    echo "</body>";
    echo "</html>";

} else {
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Error</title>";
    echo "<style>";
        echo "body { font-family: sans-serif; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; margin: 0; background-color: #f4f4f4; }";
        echo ".container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); text-align: center;}";
        echo "h1{color: red;}";
    echo "</style>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h1>Invalid pet ID.</h1>";
    echo "<a href='index.php'>Back to Home</a>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
}
?>