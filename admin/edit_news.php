<?php
$page_title = 'Admin - Edit News';
include 'admin_header.php';

$id = $_GET['id'];

// Handle form submission for updating a news article
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_news'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];

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

    $stmt = $conn->prepare("UPDATE news SET title = ?, description = ?, image = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $title, $description, $image, $content, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: news.php");
    exit();
}

// Fetch the news article from the database
$stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();
$stmt->close();

?>

<div class="container">
    <header class="hero">
        <h1>Admin - Edit News</h1>
    </header>

    <div class="admin-section">
        <h2>Edit News Article</h2>
        <form method="POST" class="admin-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="News Title" value="<?php echo htmlspecialchars($article['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Short Description" required><?php echo htmlspecialchars($article['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*">
                <p>Current Image:</p>
                <img src="../<?php echo htmlspecialchars($article['image']); ?>" alt="News Image" style="max-width: 200px; margin-top: 1em;">
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($article['image']); ?>">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" placeholder="Full Content" rows="10" required><?php echo htmlspecialchars($article['content']); ?></textarea>
            </div>
            <button type="submit" name="update_news" class="btn">Update News</button>
        </form>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
