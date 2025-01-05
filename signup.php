<?php
session_start();
require 'config.php'; // Use the same config file as login.php

// Generate CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // CSRF token validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error_message = "Invalid CSRF token.";
    }
    // Validate input fields
    else if (empty($name) || empty($surname) || empty($username) || empty($email) || empty($password)) {
        $error_message = "All fields are required.";
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    }
    else if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$/", $password)) {
        $error_message = "Password must be at least 8 characters long, with at least one uppercase letter, one lowercase letter, one number, and one special character.";
    }
    else {
        try {
            // Check for duplicate email or username
            $query = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR username = :username");
            $query->bindParam(':email', $email);
            $query->bindParam(':username', $username);
            $query->execute();
            
            if ($query->fetchColumn() > 0) {
                $error_message = "Email or username already exists.";
            } else {
                // Hash password and insert user
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $query = $pdo->prepare("INSERT INTO users (name, surname, username, email, password, is_admin) VALUES (:name, :surname, :username, :email, :password, 0)");
                $query->bindParam(':name', $name);
                $query->bindParam(':surname', $surname);
                $query->bindParam(':username', $username);
                $query->bindParam(':email', $email);
                $query->bindParam(':password', $hashed_password);
                
                if ($query->execute()) {
                    // Redirect to login page with success message
                    header("Location: login.php?signup=success");
                    exit;
                } else {
                    $error_message = "Error signing up. Please try again.";
                }
            }
        } catch (PDOException $e) {
            $error_message = "Database error. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="paw-removebg-preview.png">
    <title>Sign Up</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 2rem;
        }

        .form-control {
            font-size: 1.1rem;
            padding: 0.75rem;
            border-radius: 10px;
        }

        .btn-success {
            font-size: 1.2rem;
            padding: 0.75rem;
            border-radius: 10px;
            transition: transform 0.2s ease;
            background-color:  #3F72AF;
            color: white;
            border-color: white;
        }

        .btn-success:hover {
            transform: scale(1.05);
        }

        .form-label {
            font-size: 1.1rem;
        }


        .link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .card {
                width: 90%;
            }
        }
        .card-body form {
    display: flex;
    flex-direction: column;
    gap: 15px; 
}

.form-group {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    width: 100%;
}

.form-control {
    width: 100%;
    box-sizing: border-box;
    font-size: 1rem;
    padding: 0.5rem;
    border-radius: 10px;
    border: 1px solid #ced4da;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn {
    width: 100%; /* Ensure button matches input width */
    padding: 10px;
    font-size: 1.1rem;
    font-weight: bold;
    border-radius: 10px;
}

.text-center small {
    margin-top: 10px;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="card mx-auto" style="width: 100%; max-width: 500px;">
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="fas fa-paw" style="font-size: 3rem; color: #3F72AF;"></i>
                    <h2 class="text" style="color: #3F72AF;">Create Your Account</h2>
                </div>
                 <form action="signup.php" method="post">
                 <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="form-group">
                            <label for="name" class="form-label">First Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter your first name" required>
                        </div>
                        <div class="form-group">
                            <label for="surname" class="form-label">Last Name</label>
                            <input type="text" id="surname" name="surname" class="form-control" placeholder="Enter your last name" required>
                        </div>
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Choose a username" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                placeholder="Create a password"
                                required
                                pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$"
                                title="Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character (!@#$%^&*)"
                            >
                        </div>
                        <button class="btn btn-success" type="submit" name="submit">Sign Up</button>
                    </form>

                <div class="text-center mt-3">
                    <small>Already have an account? <a href="login.php" class="" style="color:  #3F72AF; text-decoration: none; font-size: 14px">Log In</a></small>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
