<?php
$page_title = 'Admin - Edit Property';
include 'admin_header.php';

$id = $_GET['id'];

// Handle form submission for updating a property
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_property'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    $beds = $_POST['beds'];
    $baths = $_POST['baths'];
    $sqft = $_POST['sqft'];

    $stmt = $conn->prepare("UPDATE properties SET title = ?, price = ?, location = ?, image = ?, description = ?, beds = ?, baths = ?, sqft = ? WHERE id = ?");
    $stmt->bind_param("sssssidii", $title, $price, $location, $image, $description, $beds, $baths, $sqft, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: properties.php");
    exit();
}

// Fetch the property from the database
$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$property = $result->fetch_assoc();
$stmt->close();

?>

<div class="container">
    <header class="hero">
        <h1>Admin - Edit Property</h1>
    </header>

    <div class="admin-section">
        <h2>Edit Property</h2>
        <form method="POST" class="admin-form">
            <div class="form-group">
                <label for="title">Property Title</label>
                <input type="text" id="title" name="title" placeholder="Property Title" value="<?php echo htmlspecialchars($property['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" placeholder="Price" value="<?php echo htmlspecialchars($property['price']); ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" placeholder="Location" value="<?php echo htmlspecialchars($property['location']); ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Image URL</label>
                <input type="text" id="image" name="image" placeholder="Image URL" value="<?php echo htmlspecialchars($property['image']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Description" required><?php echo htmlspecialchars($property['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="beds">Beds</label>
                <input type="number" id="beds" name="beds" placeholder="Beds" value="<?php echo htmlspecialchars($property['beds']); ?>" required>
            </div>
            <div class="form-group">
                <label for="baths">Baths</label>
                <input type="number" id="baths" name="baths" step="0.1" placeholder="Baths" value="<?php echo htmlspecialchars($property['baths']); ?>" required>
            </div>
            <div class="form-group">
                <label for="sqft">Sqft</label>
                <input type="number" id="sqft" name="sqft" placeholder="Sqft" value="<?php echo htmlspecialchars($property['sqft']); ?>" required>
            </div>
            <button type="submit" name="update_property" class="btn">Update Property</button>
        </form>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
