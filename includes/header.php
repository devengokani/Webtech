<?php
$page_title = isset($page_title) ? $page_title : 'My Website';
$css_files = isset($css_files) ? $css_files : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <?php foreach ($css_files as $css_file): ?>
        <link rel="stylesheet" href="css/<?php echo htmlspecialchars($css_file); ?>">
    <?php endforeach; ?>
</head>
<body>
    <div class="container">
        <nav>
            <div class="logo"><img src="himage/wlogo.jpg" alt="logo" class="logo-img" width=200 hight=100></div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="properties.php">Property</a></li>
                <li><a href="jobs.php">Jobs</a></li>
                <li><a href="free-downloads.php">Free Download</a></li>
                <li><a href="news.php">Tech News</a></li>
                <li><a href="blogs.php">Blog</a></li>
                <li><a href="#">Contact</a></li>
               
            </ul>
        </nav>
    </div>