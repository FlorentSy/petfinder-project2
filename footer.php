<?php
// footer.php
// Common footer for all pages
?>

    

<footer class="bg text-center text-lg-start text-white">
<footer class="bg text-center text-lg-start text-white">
    <div class="container p-2"> <!-- Reduced padding here -->
        <div class="row my-4">
            <div class="col-lg-3 col-md-6 mb-2 mb-md-0">
                <div class="rounded-circle bg-white shadow-1-strong d-flex align-items-center justify-content-center mb-4 mx-auto logo-container" style="width: 150px; height: 150px; overflow: hidden;">
                    <img src="cat_and_dog.jpg" style="width: 100%; height: 100%; object-fit: cover;" alt="" loading="lazy" />
                </div>
                <p class="text-center-left">
                    "Petfinder: Connect, adopt, list, rescue, and find loving homes for pets."
                </p>
            </div>

            <div class="col-lg-3 col-md-6 mb-2 mb-md-0" style="margin-top: 20px;">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="index.php" class="text-white"><i class="fas fa-paw pe-3"></i>Home</a>
                    </li>
                    <li class="mb-2">
                        <a href="add_pet.php" class="text-white"><i class="fas fa-paw pe-3"></i>Add a pet</a>
                    </li>
                    <li class="mb-2">
                        <a href="adopted_pets.php" class="text-white"><i class="fas fa-paw pe-3"></i>My Adopted Pets</a>
                    </li>
                    <li class="mb-2">
                        <a href="profile.php" class="text-white"><i class="fas fa-paw pe-3"></i>Edit Profile</a>
                    </li>
                    <li class="mb-2">
                        <a href="#!" class="text-white"><i class="fas fa-paw pe-3"></i>Volunteer activities</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-2 mb-md-0" style="margin-top: 20px;">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#!" class="text-white"><i class="fas fa-paw pe-3"></i>General information</a>
                    </li>
                    <li class="mb-2">
                        <a href="#!" class="text-white"><i class="fas fa-paw pe-3"></i>About the Petfinder Project</a>
                    </li>
                    <li class="mb-2">
                        <a href="#!" class="text-white"><i class="fas fa-paw pe-3"></i>Statistic data</a>
                    </li>
                    <li class="mb-2">
                        <a href="#!" class="text-white"><i class="fas fa-paw pe-3"></i>Job</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-2 mb-md-0">
                <h5 class="text-uppercase mb-2">Contact</h5>
                <ul class="list-unstyled"  style="padding: 5px;">
                    <li>
                        <p><i class="fas fa-map-marker-alt pe-2"></i>Prishtina, 123 Street, Kosovë</p>
                    </li>
                    <li>
                        <p><i class="fas fa-phone pe-2"></i>+ 01 234 567 89</p>
                    </li>
                    <li>
                        <p><i class="fas fa-envelope pe-2 mb-0"></i>petfinder@gmail.com</p>
                    </li>
                </ul>
                <ul style="list-style: none; display: flex; justify-content: left; padding: 0;">
                    <li>
                        <a class="text-white px-2" href="#!">
                            <i class="fab fa-facebook-square social-icon-large"></i>
                        </a>
                    </li>
                    <li>
                        <a class="text-white px-2" href="#!">
                            <i class="fab fa-instagram social-icon-large"></i>
                        </a>
                    </li>
                    <li>
                        <a class="text-white px-2" href="#!">
                            <i class="fab fa-twitter social-icon-large"></i>
                        </a>
                    </li>
                    <li>
                        <a class="text-white px-2" href="#!">
                            <i class="fab fa-youtube social-icon-large"></i>
                        </a>
                    </li>
                    <li>
                        <a class="text-white px-2" href="#!">
                            <i class="fab fa-linkedin social-icon-large"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="text-center p-2" style="background-color: rgba(0, 0, 0, 0.2)">
        © 2025 Copyright:
        <a class="text-white" href="#">Petfinder</a>
    </div>
</footer>

  <!-- Copyright -->
</footer>

</div>
<!-- End of .container -->
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<style>
  
    .bg {
        background-color: #3A6D8C;
    }
    .social-icon-large {
        font-size: 24px; /* You can change this value as needed */
    }
    .logo-container {
        position: relative;
        left: -50px; /* Adjust as needed to move to the left */
    }
    .container.p-3 {
        padding: 1rem; /* Reduced from default padding provided by p-3 */
    }
    .text-center-left {
      position: relative;
      left: -40px; /* Adjust as needed to move to the left */; /* Adjust this value to control how far left the text moves */
    }
    footer a {
        text-decoration: none;
        color: white; /* Ensure text color is white or another color based on your design */
    }

</style>
