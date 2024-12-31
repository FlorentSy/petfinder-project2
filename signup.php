<?php include("header.php"); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <h1 class="h3 mb-3 text-center fw-bold">Create an Account</h1>
                    <form class="form-signup" action="register.php" method="post">
                        <div class="mb-3">
                            <label for="inputName" class="form-label">Name</label>
                            <input type="text" id="inputName" class="form-control" placeholder="Enter your name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="inputSurname" class="form-label">Surname</label>
                            <input type="text" id="inputSurname" class="form-control" placeholder="Enter your surname" name="surname" required>
                        </div>

                        <div class="mb-3">
                            <label for="inputUsername" class="form-label">Username</label>
                            <input type="text" id="inputUsername" class="form-control" placeholder="Choose a username" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="email" id="inputEmail" class="form-control" placeholder="Enter your email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">Password</label>
                            <input type="password" id="inputPassword" class="form-control" placeholder="Create a password" name="password" required>
                        </div>

                        <button class="btn btn-success w-100" type="submit" name="submit">Sign Up</button>
                    </form>
                    <div class="text-center mt-3">
                        <small>Already have an account? <a href="login.php" class="text-success">Log In</a></small>
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