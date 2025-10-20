<?php 
$page_title = 'Job Listings';
$css_files = ['jobs.css'];
include 'includes/header.php'; 
require_once 'includes/db.php';

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
        <h1>Job Openings</h1>
        <p>Find your next career opportunity with us.</p>
    </header>

    <div class="job-listings">
        <?php foreach ($jobs as $job): ?>
            <div class="job-card">
                <div class="job-card-info">
                    <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                    <p><?php echo htmlspecialchars($job['location']); ?> - <?php echo htmlspecialchars($job['type']); ?></p>
                </div>
                <a href="job-detail.php?id=<?php echo $job['id']; ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>