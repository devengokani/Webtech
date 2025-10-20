<?php
$page_title = 'Admin Dashboard';
include 'admin_header.php';
?>

<div class="container">
    <header class="hero">
        <h1>Admin Dashboard</h1>
        <p>Welcome to the admin panel. Here you can manage the content of your website.</p>
    </header>

    <div class="admin-section">
        <h2>Quick Links</h2>
        <div class="quick-links">
            <a href="products.php" class="quick-link-card">
                <h3>Manage Products</h3>
                <p>Add, edit, or delete products.</p>
            </a>
            <a href="jobs.php" class="quick-link-card">
                <h3>Manage Jobs</h3>
                <p>Add, edit, or delete job listings.</p>
            </a>
            <a href="properties.php" class="quick-link-card">
                <h3>Manage Properties</h3>
                <p>Add, edit, or delete property listings.</p>
            </a>
            <a href="news.php" class="quick-link-card">
                <h3>Manage News</h3>
                <p>Add, edit, or delete news articles.</p>
            </a>
            <a href="downloads.php" class="quick-link-card">
                <h3>Manage Downloads</h3>
                <p>Add, edit, or delete downloadable files.</p>
            </a>
        </div>
    </div>
</div>

<?php include 'admin_footer.php'; ?>