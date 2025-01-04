<?php
// Include the header
include 'header.php';
?>

<div class="container my-5 flex-grow-1">
    <h1 class="text-center mb-4">About This Project</h1>
    
    <section>
        <h2>Overview</h2>
        <p>
            This project is a full-stack web application designed to offer an engaging and efficient platform for users to interact with. 
            It is built with a focus on usability, performance, and scalability, ensuring it meets modern web standards. Whether you’re 
            a developer exploring CRUD operations or a user looking for seamless functionality, this project caters to diverse needs.
        </p>
    </section>

    <section>
        <h2>Core Objectives</h2>
        <ul>
            <li><strong>Simplified User Experience:</strong> A clean, intuitive interface for all users, regardless of technical expertise.</li>
            <li><strong>Feature Integration:</strong> Enhanced interactions through responsive design, carousels, galleries, and filters.</li>
            <li><strong>Performance and Scalability:</strong> Leveraging PHP for dynamic backend operations and structured data storage using phpMyAdmin.</li>
        </ul>
    </section>

    <section>
        <h2>Key Features</h2>
        <ul>
            <li><strong>User Management:</strong> Secure and streamlined login and signup forms.</li>
            <li><strong>Data Operations:</strong> Full CRUD functionality to manage content dynamically.</li>
            <li><strong>Advanced Filtering and Search:</strong> Intuitive search bar and filters for finding information quickly.</li>
            <li><strong>Dynamic Visual Elements:</strong> Beautiful galleries and carousels for an enhanced viewing experience.</li>
            <li><strong>Customizable Experience:</strong> Options for dark mode, pagination, and drag-and-drop features.</li>
        </ul>
    </section>

    <section>
        <h2>Technologies Used</h2>
        <ul>
            <li><strong>Frontend:</strong> HTML, CSS, Bootstrap</li>
            <li><strong>Backend:</strong> PHP</li>
            <li><strong>Database:</strong> phpMyAdmin</li>
            <li><strong>Additional Tools:</strong> JavaScript for interactive features</li>
        </ul>
    </section>

    <section>
        <h2>Use Cases</h2>
        <p>
            - Perfect for learning web development and exploring full-stack integration.<br>
            - Can be deployed as a foundational system for personal projects, small businesses, or educational platforms.
        </p>
    </section>
</div>

<footer class="footer">
    <div class="text-center p-2">
        © 2025 Copyright:
        <a class="text-white" href="#"><strong>Petfinder</strong></a>
    </div>
</footer>

<style>
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
    color: rgb(40, 74, 96);
}

h1 {
    color: rgb(1, 38, 60);
}
</style>
