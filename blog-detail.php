<?php
include 'includes/header.php';
include 'includes/db.php';

$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id = $id";
$result = $conn->query($sql);
$post = $result->fetch_assoc();

// Previous post
$prev_sql = "SELECT id FROM posts WHERE id < $id ORDER BY id DESC LIMIT 1";
$prev_result = $conn->query($prev_sql);
$prev_post = $prev_result->fetch_assoc();

// Next post
$next_sql = "SELECT id FROM posts WHERE id > $id ORDER BY id ASC LIMIT 1";
$next_result = $conn->query($next_sql);
$next_post = $next_result->fetch_assoc();
?>

<link rel="stylesheet" href="css/blogs.css">

<div class="container blog-detail-container">
    <h1 class="blog-detail-title"><?php echo $post['title']; ?></h1>

    <?php if ($post['image1']): ?>
        <img src="<?php echo str_replace('../', '', $post['image1']); ?>" alt="<?php echo $post['title']; ?>" class="blog-detail-image">
    <?php endif; ?>

    <div class="blog-detail-content">
        <?php echo nl2br($post['content1']); ?>
    </div>

    <?php if ($post['image2']): ?>
        <img src="<?php echo str_replace('../', '', $post['image2']); ?>" alt="<?php echo $post['title']; ?>" class="blog-detail-image">
    <?php endif; ?>

    <div class="blog-detail-content">
        <?php echo nl2br($post['content2']); ?>
    </div>

    <?php if ($post['image3']): ?>
        <img src="<?php echo str_replace('../', '', $post['image3']); ?>" alt="<?php echo $post['title']; ?>" class="blog-detail-image">
    <?php endif; ?>

    <div class="blog-detail-content">
        <?php echo nl2br($post['content3']); ?>
    </div>

    <div class="blog-detail-info">
        <?php if ($post['brand_name']): ?>
            <h3><strong> <?php echo $post['brand_name']; ?></strong></h3>
        <?php endif; ?>
        <?php if ($post['address']): ?>
            <p><strong> <?php echo $post['address']; ?></strong></p>
        <?php endif; ?>
        <?php if ($post['mobile_number']): ?>
            <p><strong>Mobile:</strong> <?php echo $post['mobile_number']; ?></p>
        <?php endif; ?>
        <?php if ($post['whatsapp_number']): ?>
            <p><strong>WhatsApp:</strong> <?php echo $post['whatsapp_number']; ?></p>
        <?php endif; ?>
        <?php if ($post['email']): ?>
            <p><strong>Email:</strong> <?php echo $post['email']; ?></p>
        <?php endif; ?>
        <?php if ($post['website_link']): ?>
            <p><strong>Website:</strong> <a href="<?php echo $post['website_link']; ?>" target="_blank"><?php echo $post['website_link']; ?></a></p>
        <?php endif; ?>
    </div>

    <div class="blog-navigation">
        <?php if ($prev_post): ?>
            <a href="blog-detail.php?id=<?php echo $prev_post['id']; ?>">&laquo; Previous</a>
        <?php endif; ?>
        <?php if ($next_post): ?>
            <a href="blog-detail.php?id=<?php echo $next_post['id']; ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>