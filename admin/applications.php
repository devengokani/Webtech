<?php
$page_title = 'Admin - Applications';
include 'admin_header.php';

// Fetch applications from the database
$result = $conn->query("SELECT a.*, j.title AS job_title FROM applications a JOIN jobs j ON a.job_id = j.id ORDER BY a.applied_at DESC");
$applications = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
}

?>

<div class="container">
    <header class="hero">
        <h1>Admin - Job Applications</h1>
    </header>

    <div class="admin-section">
        <h2>Received Applications</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Job Title</th>
                    <th>Applicant Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Applied At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $application): ?>
                    <tr>
                        <td><?php echo $application['id']; ?></td>
                        <td><?php echo htmlspecialchars($application['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($application['name']); ?></td>
                        <td><?php echo htmlspecialchars($application['email']); ?></td>
                        <td><?php echo htmlspecialchars($application['phone']); ?></td>
                        <td><?php echo $application['applied_at']; ?></td>
                        <td class="actions">
                            <a href="../<?php echo $application['resume']; ?>" class="btn" target="_blank">View Resume</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
