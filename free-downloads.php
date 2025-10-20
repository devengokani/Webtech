<?php 
$page_title = 'Free Downloads';
$css_files = ['downloads.css'];
include 'includes/header.php'; 
require_once 'includes/db.php';

// Fetch downloads from the database
$result = $conn->query("SELECT * FROM downloads ORDER BY id DESC");
$downloads = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $downloads[] = $row;
    }
}
?>

<div class="container">
    <header class="hero">
        <h1>Free Downloads</h1>
        <p>Check out our collection of free resources.</p>
    </header>

    <div class="download-grid">
        <?php foreach ($downloads as $item): ?>
            <div class="download-card">
                <a href="download-detail.php?id=<?php echo $item['id']; ?>">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                    <div class="download-card-info">
                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                        <p><?php echo htmlspecialchars($item['description']); ?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>