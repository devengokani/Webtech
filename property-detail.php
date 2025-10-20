<?php 
require_once 'includes/db.php';

$property_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
$stmt->bind_param("i", $property_id);
$stmt->execute();
$result = $stmt->get_result();
$property = $result->fetch_assoc();
$stmt->close();

if (!$property) {
    header("HTTP/1.0 404 Not Found");
    echo 'Property not found';
    exit;
}

$page_title = $property['title'];
$css_files = ['properties.css'];
include 'includes/header.php'; 
?>

<div class="container">
    <div class="property-detail-container">
        <div class="property-detail-image">
            <img src="<?php echo htmlspecialchars($property['image']); ?>" alt="<?php echo htmlspecialchars($property['title']); ?>">
        </div>
        <div class="property-detail-info">
            <h1><?php echo htmlspecialchars($property['title']); ?></h1>
            <p class="price"><?php echo htmlspecialchars($property['price']); ?></p>
            <p class="location"><?php echo htmlspecialchars($property['location']); ?></p>
            <div class="property-details">
                <span><?php echo htmlspecialchars($property['details']['beds']); ?> beds</span>
                <span><?php echo htmlspecialchars($property['details']['baths']); ?> baths</span>
                <span><?php echo htmlspecialchars($property['details']['sqft']); ?> sqft</span>
            </div>
            <p><?php echo htmlspecialchars($property['description']); ?></p>
            <button class="contact-agent-btn">Contact Agent</button>
        </div>
    </div>
</div>

<div id="contact-modal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Contact Agent</h2>
        <form id="contact-form">
            <h3>Enter Your Details</h3>
            <input type="text" placeholder="Full Name" required>
            <input type="email" placeholder="Email Address" required>
            <input type="tel" placeholder="Phone Number" required>
            <textarea placeholder="Your Message"></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>
</div>

<?php 
$js_files = ['properties'];
include 'includes/footer.php'; 
?>