<?php 
$page_title = 'Tech News';
$css_files = ['news.css'];
include 'includes/header.php'; 
require_once 'includes/db.php';

// Fetch news from the database
$result = $conn->query("SELECT * FROM news ORDER BY id DESC");
$news = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $news[] = $row;
    }
}
?>

<div class="container">
    <header class="hero">
        <h1>Tech News</h1>
        <p>Stay up to date with the latest trends in technology.</p>
    </header>

    <div class="news-grid">
        <?php foreach ($news as $article): ?>
            <div class="news-card">
                <a href="news-detail.php?id=<?php echo $article['id']; ?>">
                    <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>">
                    <div class="news-card-info">
                        <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                        <p><?php echo htmlspecialchars($article['description']); ?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>