<?php 
$page_title = 'Property Listings';
$css_files = ['properties.css'];
include 'includes/header.php'; 
require_once 'includes/db.php';

// Fetch properties from the database
$result = $conn->query("SELECT * FROM properties ORDER BY id DESC");
$properties = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $properties[] = $row;
    }
}
?>

<div class="container">
    <header class="hero">
        <h1>Available Properties</h1>
        <p>Find your dream home with us.</p>
    </header>

    <div class="property-grid">
        <?php foreach ($properties as $property): ?>
            <div class="property-card">
                <a href="property-detail.php?id=<?php echo $property['id']; ?>">
                    <img src="<?php echo htmlspecialchars($property['image']); ?>" alt="<?php echo htmlspecialchars($property['title']); ?>">
                    <div class="property-card-info">
                        <h3><?php echo htmlspecialchars($property['title']); ?></h3>
                        <p class="price"><?php echo htmlspecialchars($property['price']); ?></p>
                        <p class="location"><?php echo htmlspecialchars($property['location']); ?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>