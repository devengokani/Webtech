<?php
$page_title = 'Admin - Edit Download';
include 'admin_header.php';

$id = $_GET['id'];

// Handle form submission for updating a download
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_download'])) {
    $title = $_POST['title'];
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
                echo "Sorry, there was an error uploading your image file.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    $file_path = $_POST['current_file'];
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

    $stmt = $conn->prepare("UPDATE downloads SET title = ?, description = ?, image = ?, file = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $title, $description, $image, $file_path, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: downloads.php");
    exit();
}

// Fetch the download from the database
$stmt = $conn->prepare("SELECT * FROM downloads WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$download = $result->fetch_assoc();
$stmt->close();

?>

<div class="container">
    <header class="hero">
        <h1>Admin - Edit Download</h1>
    </header>

    <div class="admin-section">
        <h2>Edit Download</h2>
        <form method="POST" class="admin-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="Download Title" value="<?php echo htmlspecialchars($download['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Short Description" required><?php echo htmlspecialchars($download['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*">
                <p>Current Image:</p>
                <img src="../<?php echo htmlspecialchars($download['image']); ?>" alt="Download Image" style="max-width: 200px; margin-top: 1em;">
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($download['image']); ?>">
            </div>
            <div class="form-group">
                <label for="file">File</label>
                <input type="file" id="file" name="file">
                <p>Current File: <a href="../<?php echo htmlspecialchars($download['file']); ?>" target="_blank"><?php echo htmlspecialchars(basename($download['file'])); ?></a></p>
                <input type="hidden" name="current_file" value="<?php echo htmlspecialchars($download['file']); ?>">
            </div>
            <button type="submit" name="update_download" class="btn">Update Download</button>
        </form>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
