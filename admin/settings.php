<?php
$page_title = 'Admin - Settings';
include 'admin_header.php';

// Handle form submission for updating settings
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
    if (isset($_FILES['qr_code_image']) && $_FILES['qr_code_image']['error'] == 0) {
        $upload_dir = 'uploads/';
        if (!is_dir('../' . $upload_dir)) {
            mkdir('../' . $upload_dir, 0755, true);
        }
        $qr_code_image = $upload_dir . basename($_FILES['qr_code_image']['name']);
        $image_file_type = strtolower(pathinfo($qr_code_image, PATHINFO_EXTENSION));

        // Check if file is an image
        $check = getimagesize($_FILES['qr_code_image']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['qr_code_image']['tmp_name'], '../' . $qr_code_image)) {
                $stmt = $conn->prepare("UPDATE settings SET value = ? WHERE name = 'qr_code_image'");
                $stmt->bind_param("s", $qr_code_image);
                $stmt->execute();
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    }
}

// Fetch settings from the database
$result = $conn->query("SELECT * FROM settings");
$settings = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $settings[$row['name']] = $row['value'];
    }
}

?>

<div class="container">
    <header class="hero">
        <h1>Admin - Settings</h1>
    </header>

    <div class="admin-section">
        <h2>Update Settings</h2>
        <form method="POST" class="admin-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="qr_code_image">QR Code Image</label>
                <input type="file" id="qr_code_image" name="qr_code_image" accept="image/*">
                <p>Current QR Code:</p>
                <img src="../<?php echo htmlspecialchars($settings['qr_code_image']); ?>" alt="QR Code" style="max-width: 200px; margin-top: 1em;">
            </div>
            <button type="submit" name="update_settings" class="btn">Update Settings</button>
        </form>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
