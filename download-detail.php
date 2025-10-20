<?php 
require_once 'includes/db.php';

$download_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM downloads WHERE id = ?");
$stmt->bind_param("i", $download_id);
$stmt->execute();
$result = $stmt->get_result();
$download = $result->fetch_assoc();
$stmt->close();

if (!$download) {
    header("HTTP/1.0 404 Not Found");
    echo 'Download not found';
    exit;
}

$page_title = $download['title'];
$css_files = ['downloads.css'];
include 'includes/header.php'; 
?>

<div class="container">
    <div class="download-detail-container">
        <div class="download-detail-image">
            <img src="<?php echo htmlspecialchars($download['image']); ?>" alt="<?php echo htmlspecialchars($download['title']); ?>">
        </div>
        <div class="download-detail-info">
            <h1><?php echo htmlspecialchars($download['title']); ?></h1>
            <p><?php echo htmlspecialchars($download['description']); ?></p>
            <a href="<?php echo htmlspecialchars($download['file']); ?>" class="download-now-btn" download>Download Now</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>