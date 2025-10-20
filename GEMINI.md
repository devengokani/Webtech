# Project Overview

This project is a simple, multi-page PHP website. It appears to be a business or portfolio site with sections for products, properties, jobs, news, and free downloads. The site is built with plain PHP and does not use a database. Instead, data is stored in PHP arrays within files in the `data` directory.

## Main Technologies

*   **Backend:** PHP
*   **Frontend:** HTML, CSS, JavaScript
*   **Data Storage:** PHP files acting as a simple file-based data store.

## Project Structure

The project follows a basic structure separating presentation, logic, and data:

*   **Root Directory (`/`)**: Contains the main user-facing PHP pages (e.g., `index.php`, `products.php`).
*   **`admin/`**: Contains the administrative interface.
*   **`css/`**: Contains all the CSS files for styling the website.
*   **`js/`**: Contains JavaScript files for client-side interactivity.
*   **`data/`**: Contains PHP files that hold the website's content in PHP arrays. Each file corresponds to a section of the site (e.g., `data/products.php`).
*   **`includes/`**: Contains reusable PHP files for common page elements like the header (`header.php`) and footer (`footer.php`).

# Building and Running

This project does not have a build process. To run it, you need a local web server with PHP installed, such as XAMPP, WAMP, or MAMP.

1.  **Place the project files** in the document root of your web server (e.g., the `htdocs` folder in XAMPP).
2.  **Start your web server.**
3.  **Access the project** in your web browser by navigating to the appropriate local URL (e.g., `http://localhost/webtech/`).

# Development Conventions

*   **Templating:** The site uses a simple templating system where `header.php` and `footer.php` are included in each main page to maintain a consistent layout.
*   **Data Management:** Content is managed by editing the PHP arrays in the `data/` directory. Each section of the site has its own data file.
*   **Styling:** Each major section of the site has its own CSS file (e.g., `products.css`, `jobs.css`), which is included in the header. A global `style.css` provides the base styles.
*   **Dynamic Pages:** The detail pages (e.g., `product-detail.php`) likely use URL parameters (e.g., `?id=...`) to fetch and display specific items from the data files.
