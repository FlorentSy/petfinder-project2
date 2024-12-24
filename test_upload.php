<?php
$upload_dir = "uploads/";

// Check if directory exists
if (!file_exists($upload_dir)) {
    echo "Warning: uploads directory does not exist!<br>";
} else {
    echo "Good: uploads directory exists!<br>";
}

// Check if directory is writable
if (is_writable($upload_dir)) {
    echo "Good: uploads directory is writable!<br>";
} else {
    echo "Warning: uploads directory is not writable!<br>";
}

// Try to create a test file
$test_file = $upload_dir . "test.txt";
if (file_put_contents($test_file, "Test content")) {
    echo "Good: Successfully created test file!<br>";
    unlink($test_file); // Clean up
} else {
    echo "Warning: Could not create test file!<br>";
}
?>