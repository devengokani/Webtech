<?php
require_once 'includes/db.php';

$job_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_job'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $resume_dir = 'resumes/';
    $resume_file = $resume_dir . basename($_FILES['resume']['name']);
    $resume_file_type = strtolower(pathinfo($resume_file, PATHINFO_EXTENSION));

    // Check if file is a pdf, doc, or docx
    if ($resume_file_type != "pdf" && $resume_file_type != "doc" && $resume_file_type != "docx") {
        echo "Sorry, only PDF, DOC, & DOCX files are allowed.";
    } else {
        // Create a unique filename
        $new_resume_file = $resume_dir . uniqid() . '.' . $resume_file_type;
        if (move_uploaded_file($_FILES['resume']['tmp_name'], $new_resume_file)) {
            $stmt = $conn->prepare("INSERT INTO applications (job_id, name, email, phone, resume) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $job_id, $name, $email, $phone, $new_resume_file);
            $stmt->execute();
            $stmt->close();
            header("Location: application-success.php?name=" . urlencode($name));
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();
$stmt->close();

if ($job) {
    $job['responsibilities'] = explode('\n', $job['responsibilities']);
    $job['qualifications'] = explode('\n', $job['qualifications']);
}

if (!$job) {
    header("HTTP/1.0 404 Not Found");
    echo 'Job not found';
    exit;
}

$page_title = $job['title'];
$css_files = ['jobs.css'];
include 'includes/header.php'; 
?>

<div class="container">
    <div class="job-detail-container">
        <div class="job-detail-header">
            <h1><?php echo htmlspecialchars($job['title']); ?></h1>
            <a href="#" class="apply-now-btn">Apply Now</a>
        </div>
        <div class="job-detail-body">
            <p><?php echo htmlspecialchars($job['description']); ?></p>
            <h3>Responsibilities</h3>
            <ul>
                <?php foreach ($job['responsibilities'] as $responsibility): ?>
                    <li><?php echo htmlspecialchars($responsibility); ?></li>
                <?php endforeach; ?>
            </ul>
            <h3>Qualifications</h3>
            <ul>
                <?php foreach ($job['qualifications'] as $qualification): ?>
                    <li><?php echo htmlspecialchars($qualification); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<div id="application-modal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Apply for this Job</h2>
        <form id="application-form" method="POST" enctype="multipart/form-data">
            <h3>Enter Your Details</h3>
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <label for="resume">Upload Your Resume:</label>
            <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
            <button type="submit" name="apply_job">Submit Application</button>
        </form>
    </div>
</div>

<?php 
$js_files = ['jobs'];
include 'includes/footer.php'; 
?>