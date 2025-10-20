<?php
$page_title = 'Admin - Edit Product';
include 'admin_header.php';

$id = $_GET['id'];

// Handle form submission for updating a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $image = $_POST['current_image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'uploads/';
        $image_file = $upload_dir . basename($_FILES['image']['name']);
        $image_file_type = strtolower(pathinfo($image_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            $new_image_file = $upload_dir . uniqid() . '.' . $image_file_type;
            if (move_uploaded_file($_FILES['image']['tmp_name'], '../' . $new_image_file)) {
                $image = $new_image_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, image = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $price, $image, $description, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: products.php");
    exit();
}

// Fetch the product from the database
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

?>

<div class="container">
    <header class="hero">
        <h1>Admin - Edit Product</h1>
    </header>

    <div class="admin-section">
        <h2>Edit Product</h2>
        <form method="POST" class="admin-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" placeholder="Product Name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" placeholder="Price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*">
                <p>Current Image:</p>
                <img src="../<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" style="max-width: 200px; margin-top: 1em;">
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($product['image']); ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <button type="submit" name="update_product" class="btn">Update Product</button>
        </form>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
