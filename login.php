<?php include("header.php"); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <h1 class="h3 mb-3 text-center fw-bold">Sign In</h1>
                    <form class="form-login" action="loginLogic.php" method="post">
                        <div class="mb-3">
                            <label for="inputUsername" class="form-label">Username</label>
                            <input type="text" id="inputUsername" class="form-control" placeholder="Enter your username" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">Password</label>
                            <input type="password" id="inputPassword" class="form-control" placeholder="Enter your password" name="password" required>
                        </div>

                        <button class="btn btn-success w-100" type="submit" name="submit">Sign In</button>
                    </form>
                    <div class="text-center mt-3">
                        <small>Don't have an account? <a href="signup.php" class="text-success">Sign Up</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

<style>
	body {
    background-color: #f8f9fa; /* Light background for better contrast */
}

.card {
    border: none;
    border-radius: 10px;
}

.card-body {
    padding: 30px;
}

.btn-success {
    background-color: green;
    border: none;
    font-size: 16px;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 5px;
    transition: all 0.3s ease-in-out;
}

.btn-success:hover {
    background-color: green;
}

.form-control {
    border-radius: 5px;
    border: 1px solid #ced4da;
    box-shadow: none;
    transition: border-color 0.2s ease-in-out;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.text-success {
    font-weight: bold;
    text-decoration: none;
}

.text-success:hover {
    text-decoration: underline;
}
</style>