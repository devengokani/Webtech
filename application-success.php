<?php
$page_title = 'Application Submitted';
$css_files = ['success.css'];
include 'includes/header.php';

$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Guest';
?>

<div class="container success-container">
    <div class="success-card">
        <div class="success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
            </svg>
        </div>
        <h1>Application Submitted!</h1>
        <p>Thank you, <?php echo $name; ?>, for applying for the position. We have received your application and will be in touch shortly.</p>
        <a href="index.php" class="btn">Back to Home</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
