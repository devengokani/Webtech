<?php 
$page_title = 'Products';
$css_files = ['products.css'];
include 'includes/header.php'; 
require_once 'includes/db.php';

// Fetch products from the database
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<div class="container">
    <header class="hero">
        <h1>Our Products</h1>
        <p>Discover our collection of amazing products.</p>
    </header>

    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <a href="product-detail.php?id=<?php echo $product['id']; ?>">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="price"><?php echo htmlspecialchars($product['price']); ?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>