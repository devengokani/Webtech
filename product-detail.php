<?php 
require_once 'includes/db.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_now'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $screenshot_dir = 'screenshots/';
    $screenshot_file = $screenshot_dir . basename($_FILES['screenshot']['name']);
    $screenshot_file_type = strtolower(pathinfo($screenshot_file, PATHINFO_EXTENSION));

    // Check if file is an image
    $check = getimagesize($_FILES['screenshot']['tmp_name']);
    if ($check !== false) {
        // Create a unique filename
        $new_screenshot_file = $screenshot_dir . uniqid() . '.' . $screenshot_file_type;
        if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $new_screenshot_file)) {
            $stmt = $conn->prepare("INSERT INTO orders (product_id, name, email, address, screenshot) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $product_id, $name, $email, $address, $new_screenshot_file);
            $stmt->execute();
            $stmt->close();
            header("Location: order-success.php?name=" . urlencode($name));
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

// Fetch QR code from settings
$qr_code_result = $conn->query("SELECT value FROM settings WHERE name = 'qr_code_image'");
$qr_code_row = $qr_code_result->fetch_assoc();
$qr_code_image = $qr_code_row['value'];

if (!$product) {
    header("HTTP/1.0 404 Not Found");
    echo 'Product not found';
    exit;
}

$page_title = $product['name'];
$css_files = ['products.css'];
include 'includes/header.php'; 
?>

<div class="container">
    <div class="product-detail-container">
        <div class="product-detail-image">
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        <div class="product-detail-info">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="price"><?php echo htmlspecialchars($product['price']); ?></p>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <button class="add-to-cart-btn">Buy Now</button>
        </div>
    </div>
</div>

<div id="payment-modal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Complete Your Purchase</h2>
        <div class="payment-details">
            <div class="qr-code">
                <img src="<?php echo htmlspecialchars($qr_code_image); ?>" alt="QR Code">
                <p>Scan the QR code to complete the payment.</p>
            </div>
            <form id="payment-form" method="POST" enctype="multipart/form-data">
                <h3>Enter Your Details</h3>
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <textarea name="address" placeholder="Shipping Address" required></textarea>
                <label for="screenshot">Upload Payment Screenshot:</label>
                <input type="file" id="screenshot" name="screenshot" accept="image/*" required>
                <button type="submit" name="buy_now">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php 
$js_files = ['products'];
include 'includes/footer.php'; 
?>