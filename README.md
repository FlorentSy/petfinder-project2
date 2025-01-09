# Petfinder Project

## Overview
The Petfinder Project is a full-stack web application designed to help users find and adopt pets. It includes features like user authentication, pet search, signup, and more. The application is built using PHP for the backend, HTML, CSS, and Bootstrap for the frontend, and phpMyAdmin/MySQL for the database.

## Features
- **User Authentication**: Secure login and signup functionality.
- **Pet Listings**: Browse and search for pets available for adoption.
- **Responsive Design**: Built with Bootstrap for seamless use across devices.
- **Dark Mode**: A toggleable dark mode for better accessibility.
- **Pagination and Sorting**: Navigate pet listings with ease and sort based on preferences.
- **Drag-and-Drop**: Enhanced interactivity using JavaScript.

## Folder Structure
```
project-root/
├── header.php         # Shared header for pages
├── login.php          # Login page for user authentication
├── signup.php         # Signup page for new users
├── index.php          # Homepage with pet listings
├── assets/            # CSS, JS, and image files
├── db/                # Database-related files
├── includes/          # Common PHP functions and utilities
└── README.md          # Project documentation
```

## Technologies Used
- **Frontend**: HTML, CSS, Bootstrap
- **Backend**: PHP, JS
- **Database**: MySQL with phpMyAdmin

## Getting Started
### Prerequisites
- PHP >= 7.4
- MySQL Server
- A local server environment like XAMPP, WAMP, or LAMP

### Installation
1. Clone the repository:
   ```bash
   git clone <repository-url>
   ```
2. Move the files to your local server directory (e.g., `htdocs` for XAMPP or `www` for WAMP) .
3. Import the database:
   - Open phpMyAdmin.
   - Create a new database (e.g., `petfinder`).
   - Import the SQL file provided in the `db/` directory.
4. Update the database connection settings in `includes/db_config.php`.

### Usage
1. Start your local server (e.g., Apache and MySQL in XAMPP).
2. Navigate to `http://localhost/<project-folder>` in your browser.
3. Sign up or log in to explore the features.

## Future Enhancements
- **E-commerce Integration**: Allow users to purchase pet-related products.
- **Advanced Filters**: Add more filters for easier pet search.
- **Mobile App**: Expand to mobile platforms for wider reach.

## Contributing
Contributions are welcome! Feel free to fork this repository and submit a pull request with your changes.

## License
This project is licensed under the MIT License. See the LICENSE file for details.

---

**Happy Coding!**
