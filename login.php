<?php
session_start();
require 'config.php';

if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']); // Sanitize input
    $password = ($_POST['password']); // Sanitize input

    if (empty($username) || empty($password)) {
        header("Location: login.php?error=emptyfields");
        exit;
    }

    // Check login attempts (brute force protection)
    $sql = "SELECT * FROM login_attempts WHERE username = :username";
    $query = $pdo->prepare($sql);
    $query->bindParam(':username', $username);
    $query->execute();
    $attempt = $query->fetch();

    if ($attempt && $attempt['attempts'] >= 5 && time() - strtotime($attempt['last_attempt']) < 900) {
        header("Location: login.php?error=too_many_attempts");
        exit;
    }

    // Fetch user by username (case insensitive)
    $sql = "SELECT * FROM users WHERE LOWER(username) = LOWER(:username)";
    $query = $pdo->prepare($sql);
    $query->bindParam(':username', $username);
    $query->execute();

    if ($query->rowCount() > 0) {
        $user = $query->fetch();

        // Verify password
        if (password_verify($password, $user['password'])) {
            echo "Password verified successfully!<br>";

            // Rehash password if needed
            if (password_needs_rehash($user['password'], PASSWORD_BCRYPT)) {
                $newHash = password_hash($password, PASSWORD_BCRYPT);
                $sql = "UPDATE users SET password = :password WHERE id = :id";
                $updatePassword = $pdo->prepare($sql);
                $updatePassword->bindParam(':password', $newHash);
                $updatePassword->bindParam(':id', $user['id']);
                $updatePassword->execute();
            }

            // Reset login attempts on successful login
            $sql = "DELETE FROM login_attempts WHERE username = :username";
            $resetAttempts = $pdo->prepare($sql);
            $resetAttempts->bindParam(':username', $username);
            $resetAttempts->execute();

            // Set session variables
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];

            header("Location: index.php?login=success");
            exit;
        } else {
            // Increment login attempts on incorrect password
            if (!$attempt) {
                $sql = "INSERT INTO login_attempts (username, attempts) VALUES (:username, 1)";
            } else {
                $sql = "UPDATE login_attempts SET attempts = attempts + 1, last_attempt = CURRENT_TIMESTAMP WHERE username = :username";
            }
            $updateAttempts = $pdo->prepare($sql);
            $updateAttempts->bindParam(':username', $username);
            $updateAttempts->execute();

            header("Location: login.php?error=incorrectpassword");
            exit;
        }
    } else {
        header("Location: login.php?error=usernotfound");
        exit;
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
    <title>Login</title>
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
            width: 100%;
            max-width: 500px;
        }

        .card-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 0.75rem;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 8px;
        }
        .btn-primary:hover {
            transform: scale(1.05);
        }
        .text-center small {
            margin-top: 10px;
        }

        .link {
            text-decoration: none;
            color: green;
        }

        .link:hover {
            text-decoration: underline;
        }

        .alert {
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .card {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="fas fa-paw text-primary" style="font-size: 3rem;"></i>
                    <h2 class="text-primary">Welcome Back!</h2>
                </div>
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger text-center">
                        <?php
                        switch($_GET['error']) {
                            case 'emptyfields':
                                echo 'Please fill in all fields.';
                                break;
                            case 'incorrectpassword':
                                echo 'Incorrect password.';
                                break;
                            case 'usernotfound':
                                echo 'User not found.';
                                break;
                            case 'too_many_attempts':
                                echo 'Too many failed attempts. Please try again in 15 minutes.';
                                break;
                            default:
                                echo 'An error occurred. Please try again.';
                        }
                        ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_GET['signup']) && $_GET['signup'] == 'success'): ?>
                    <div class="alert alert-success text-center">
                        Registration successful! Please log in.
                    </div>
                <?php endif; ?>
                <form action="login.php" method="post">
                    <div class="form-group" style="margin-right: 20px;">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required>
                    </div>
                    <div class="form-group" style="margin-right: 20px;">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <button class="btn btn-primary" type="submit" name="submit">Log In</button>
                </form>
                <div class="text-center mt-3">
                    <small>Don't have an account? <a href="signup.php" class="link">Sign Up</a></small>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
