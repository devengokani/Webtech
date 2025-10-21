<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Admin'; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="container">
        <nav>
            <div class="logo">Admin Panel</div>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="jobs.php">Jobs</a></li>
                <li><a href="properties.php">Properties</a></li>
                <li><a href="news.php">News</a></li>
                <li><a href="downloads.php">Downloads</a></li>
                <li><a href="posts.php">Posts</a></li>
                <li><a href="applications.php">Applications</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../index.php" target="_blank">View Site</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
