<?php 
require_once 'includes/db.php';

$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();
$stmt->close();

if (!$article) {
    header("HTTP/1.0 404 Not Found");
    echo 'Article not found';
    exit;
}

$page_title = $article['title'];
$css_files = ['news.css'];
include 'includes/header.php'; 
?>

<div class="container">
    <div class="news-detail-container">
        <div class="news-detail-header">
            <h1><?php echo htmlspecialchars($article['title']); ?></h1>
            <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>">
        </div>
        <div class="news-detail-content">
            <p><?php echo nl2br(htmlspecialchars($article['content'])); ?></p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>