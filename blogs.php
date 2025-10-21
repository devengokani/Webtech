<?php
include 'includes/header.php';
include 'includes/db.php';

$sql = "SELECT id, title, image1 FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<link rel="stylesheet" href="css/blogs.css">

<div class="container">
    <h2 class="page-title">Our Blog</h2>
    <div class="blog-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="blog-card">
                <a href="blog-detail.php?id=<?php echo $row['id']; ?>">
                    <?php if ($row['image1']): ?>
                        <img src="<?php echo str_replace('../', '', $row['image1']); ?>" alt="<?php echo $row['title']; ?>">
                    <?php endif; ?>
                    <div class="blog-card-content">
                        <h3><?php echo $row['title']; ?></h3>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>