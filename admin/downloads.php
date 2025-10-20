<?php
$page_title = 'Admin - Downloads';
include 'admin_header.php';

// Handle form submission for adding a new download
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_download'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $image = '';
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
                echo "Sorry, there was an error uploading your image file.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    $file_path = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $download_dir = 'downloads/';
        $uploaded_file = $download_dir . basename($_FILES['file']['name']);
        $uploaded_file_type = strtolower(pathinfo($uploaded_file, PATHINFO_EXTENSION));

        $new_uploaded_file = $download_dir . uniqid() . '.' . $uploaded_file_type;
        if (move_uploaded_file($_FILES['file']['tmp_name'], '../' . $new_uploaded_file)) {
            $file_path = $new_uploaded_file;
        } else {
            echo "Sorry, there was an error uploading your download file.";
        }
    }

    $stmt = $conn->prepare("INSERT INTO downloads (title, description, image, file) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $image, $file_path);
    $stmt->execute();
    $stmt->close();
}

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM downloads WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

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
        <h1>Admin - Manage Downloads</h1>
    </header>

    <div class="admin-section">
        <h2>Add New Download</h2>
        <form method="POST" class="admin-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="Download Title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Short Description" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="file">File</label>
                <input type="file" id="file" name="file" required>
            </div>
            <button type="submit" name="add_download" class="btn">Add Download</button>
        </form>
    </div>

    <div class="admin-section">
        <h2>Existing Downloads</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($downloads as $download): ?>
                    <tr>
                        <td><?php echo $download['id']; ?></td>
                        <td><?php echo htmlspecialchars($download['title']); ?></td>
                        <td class="actions">
                            <a href="edit_download.php?id=<?php echo $download['id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="downloads.php?delete=<?php echo $download['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this download?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
