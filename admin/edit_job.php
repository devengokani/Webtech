<?php
$page_title = 'Admin - Edit Job';
include 'admin_header.php';

$id = $_GET['id'];

// Handle form submission for updating a job
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_job'])) {
    $title = $_POST['title'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $responsibilities = $_POST['responsibilities'];
    $qualifications = $_POST['qualifications'];

    $stmt = $conn->prepare("UPDATE jobs SET title = ?, location = ?, type = ?, description = ?, responsibilities = ?, qualifications = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $title, $location, $type, $description, $responsibilities, $qualifications, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: jobs.php");
    exit();
}

// Fetch the job from the database
$stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();
$stmt->close();

?>

<div class="container">
    <header class="hero">
        <h1>Admin - Edit Job</h1>
    </header>

    <div class="admin-section">
        <h2>Edit Job</h2>
        <form method="POST" class="admin-form">
            <div class="form-group">
                <label for="title">Job Title</label>
                <input type="text" id="title" name="title" placeholder="Job Title" value="<?php echo htmlspecialchars($job['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" placeholder="Location" value="<?php echo htmlspecialchars($job['location']); ?>" required>
            </div>
            <div class="form-group">
                <label for="type">Job Type</label>
                <input type="text" id="type" name="type" placeholder="Job Type" value="<?php echo htmlspecialchars($job['type']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Description" required><?php echo htmlspecialchars($job['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="responsibilities">Responsibilities (one per line)</label>
                <textarea id="responsibilities" name="responsibilities" placeholder="Responsibilities (one per line)" required><?php echo htmlspecialchars($job['responsibilities']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="qualifications">Qualifications (one per line)</label>
                <textarea id="qualifications" name="qualifications" placeholder="Qualifications (one per line)" required><?php echo htmlspecialchars($job['qualifications']); ?></textarea>
            </div>
            <button type="submit" name="update_job" class="btn">Update Job</button>
        </form>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
