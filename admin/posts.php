<?php
include 'admin_header.php';
include '../includes/db.php';

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div class="container">
    <h2>Blog Posts</h2>
    <a href="create_post.php" class="btn btn-primary mb-3">Create Post</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_post.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'admin_footer.php'; ?>