<?php
$page_title = 'Admin - Properties';
include 'admin_header.php';

// Handle form submission for adding a new property
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_property'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    $beds = $_POST['beds'];
    $baths = $_POST['baths'];
    $sqft = $_POST['sqft'];

    $stmt = $conn->prepare("INSERT INTO properties (title, price, location, image, description, beds, baths, sqft) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssidi", $title, $price, $location, $image, $description, $beds, $baths, $sqft);
    $stmt->execute();
    $stmt->close();
}

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM properties WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

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
        <h1>Admin - Manage Properties</h1>
    </header>

    <div class="admin-section">
        <h2>Add New Property</h2>
        <form method="POST" class="admin-form">
            <div class="form-group">
                <label for="title">Property Title</label>
                <input type="text" id="title" name="title" placeholder="Property Title" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" placeholder="Price" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" placeholder="Location" required>
            </div>
            <div class="form-group">
                <label for="image">Image URL</label>
                <input type="text" id="image" name="image" placeholder="Image URL" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Description" required></textarea>
            </div>
            <div class="form-group">
                <label for="beds">Beds</label>
                <input type="number" id="beds" name="beds" placeholder="Beds" required>
            </div>
            <div class="form-group">
                <label for="baths">Baths</label>
                <input type="number" id="baths" name="baths" step="0.1" placeholder="Baths" required>
            </div>
            <div class="form-group">
                <label for="sqft">Sqft</label>
                <input type="number" id="sqft" name="sqft" placeholder="Sqft" required>
            </div>
            <button type="submit" name="add_property" class="btn">Add Property</button>
        </form>
    </div>

    <div class="admin-section">
        <h2>Existing Properties</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($properties as $property): ?>
                    <tr>
                        <td><?php echo $property['id']; ?></td>
                        <td><?php echo htmlspecialchars($property['title']); ?></td>
                        <td><?php echo htmlspecialchars($property['price']); ?></td>
                        <td><?php echo htmlspecialchars($property['location']); ?></td>
                        <td class="actions">
                            <a href="edit_property.php?id=<?php echo $property['id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="properties.php?delete=<?php echo $property['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this property?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'admin_footer.php'; ?>