<?php
$page_title = 'Admin - Jobs';
include 'admin_header.php';

// Handle form submission for adding a new job
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_job'])) {
    $title = $_POST['title'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $responsibilities = $_POST['responsibilities'];
    $qualifications = $_POST['qualifications'];

    $stmt = $conn->prepare("INSERT INTO jobs (title, location, type, description, responsibilities, qualifications) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $title, $location, $type, $description, $responsibilities, $qualifications);
    $stmt->execute();
    $stmt->close();
}

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Fetch jobs from the database
$result = $conn->query("SELECT * FROM jobs ORDER BY id DESC");
$jobs = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }
}

?>

<div class="container">
    <header class="hero">
        <h1>Admin - Manage Jobs</h1>
    </header>

    <div class="admin-section">
        <h2>Add New Job</h2>
        <form method="POST" class="admin-form">
            <div class="form-group">
                <label for="title">Job Title</label>
                <input type="text" id="title" name="title" placeholder="Job Title" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" placeholder="Location" required>
            </div>
            <div class="form-group">
                <label for="type">Job Type</label>
                <input type="text" id="type" name="type" placeholder="Job Type" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Description" required></textarea>
            </div>
            <div class="form-group">
                <label for="responsibilities">Responsibilities (one per line)</label>
                <textarea id="responsibilities" name="responsibilities" placeholder="Responsibilities (one per line)" required></textarea>
            </div>
            <div class="form-group">
                <label for="qualifications">Qualifications (one per line)</label>
                <textarea id="qualifications" name="qualifications" placeholder="Qualifications (one per line)" required></textarea>
            </div>
            <button type="submit" name="add_job" class="btn">Add Job</button>
        </form>
    </div>

    <div class="admin-section">
        <h2>Existing Jobs</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td><?php echo $job['id']; ?></td>
                        <td><?php echo htmlspecialchars($job['title']); ?></td>
                        <td><?php echo htmlspecialchars($job['location']); ?></td>
                        <td><?php echo htmlspecialchars($job['type']); ?></td>
                        <td class="actions">
                            <a href="edit_job.php?id=<?php echo $job['id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="jobs.php?delete=<?php echo $job['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'admin_footer.php'; ?>