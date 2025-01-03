<?php
// Include the header
include 'header.php';
?>

<div class="container my-5">
    <h1 class="text-center mb-4">The Petfinder Project</h1>
    
    <section>
        <h2>What is The Petfinder Project?</h2>
        <p>
            <strong>The Petfinder Project</strong> is a platform dedicated to connecting pet owners and adopters. It provides a simple and 
            efficient way to help individuals adopt pets in need of homes and give pet owners the opportunity to find loving families 
            for their pets.
        </p>
    </section>

    <section>
        <h2>How Does It Work?</h2>
        <ul>
            <li>
                <strong>Adopt a Pet:</strong> Browse profiles of pets looking for homes. Each profile includes details like age, breed, 
                personality traits, and special needs.
            </li>
            <li>
                <strong>Give Pets for Adoption:</strong> Pet owners can create detailed listings for their pets, making it easier to find 
                suitable adopters.
            </li>
            <li>
                <strong>Connect Directly:</strong> Facilitates communication between pet owners and adopters to ensure the best match.
            </li>
        </ul>
    </section>

    <section>
        <h2>Key Features</h2>
        <ul>
            <li><strong>Search and Filter:</strong> Quickly find pets by type, age, size, or location.</li>
            <li><strong>Detailed Pet Profiles:</strong> Each pet has a unique profile with pictures and descriptions.</li>
            <li><strong>User Accounts:</strong> Allows users to save favorites and track adoption inquiries.</li>
            <li><strong>Responsive Design:</strong> Works seamlessly across desktop, tablet, and mobile devices.</li>
        </ul>
    </section>

    <section>
        <h2>Our Mission</h2>
        <p>
            Our mission is to provide a platform where every pet has a chance to find a loving home. By bridging the gap between pet owners 
            and adopters, <strong>The Petfinder Project</strong> makes the adoption process more transparent and efficient.
        </p>
    </section>
</div>

<footer class="footer">
    <div class="text-center p-2">
        © 2025 Copyright:
        <a class="text-white" href="#"><strong>The Petfinder Project</strong></a>
    </div>
</footer>

<style>
/* Page and Footer Styles */
html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

.container {
    flex-grow: 1;
}

footer {
    background-color: #3A6D8C;
    color: white;
    text-align: center;
    padding: 0.7rem 0;
    position: relative;
}

footer a {
    text-decoration: none;
    color: white;
}

.footer {
    flex-shrink: 0;
}
h2 {
    color:rgb(40, 74, 96);
}
h1 {
    color:rgb(1, 38, 60);
}
</style>
