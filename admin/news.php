<?php
$page_title = 'Admin - News';
include 'admin_header.php';

// Handle form submission for adding a new news article
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_news'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];

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
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    $stmt = $conn->prepare("INSERT INTO news (title, description, image, content) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $image, $content);
    $stmt->execute();
    $stmt->close();
}

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Fetch news from the database
$result = $conn->query("SELECT * FROM news ORDER BY id DESC");
$news_articles = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $news_articles[] = $row;
    }
}

?>

<div class="container">
    <header class="hero">
        <h1>Admin - Manage News</h1>
    </header>

    <div class="admin-section">
        <h2>Add New News Article</h2>
        <form method="POST" class="admin-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="News Title" required>
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
                <label for="content">Content</label>
                <textarea id="content" name="content" placeholder="Full Content" rows="10" required></textarea>
            </div>
            <button type="submit" name="add_news" class="btn">Add News</button>
        </form>
    </div>

    <div class="admin-section">
        <h2>Existing News Articles</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($news_articles as $article): ?>
                    <tr>
                        <td><?php echo $article['id']; ?></td>
                        <td><?php echo htmlspecialchars($article['title']); ?></td>
                        <td class="actions">
                            <a href="edit_news.php?id=<?php echo $article['id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="news.php?delete=<?php echo $article['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this article?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
