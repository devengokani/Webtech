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
                <li><a href="#">Contact</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Other Links</a>
                    <div class="dropdown-content">
                        <a href="https://www.google.com" target="_blank">Google</a>
                        <a href="https://www.github.com" target="_blank">GitHub</a>
                        <a href="https://www.linkedin.com" target="_blank">LinkedIn</a>
                        <a href="https://www.stackoverflow.com" target="_blank">Stack Overflow</a>
                        <a href="https://www.medium.com" target="_blank">Medium</a>
                        <a href="https://www.dribbble.com" target="_blank">Dribbble</a>
                        <a href="https://www.behance.net" target="_blank">Behance</a>
                        <a href="https://www.codepen.io" target="_blank">CodePen</a>
                        <a href="https://www.freecodecamp.org" target="_blank">freeCodeCamp</a>
                        <a href="https://www.w3schools.com" target="_blank">W3Schools</a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>