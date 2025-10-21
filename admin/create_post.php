<?php
include 'admin_header.php';

$page_title = "Create Post";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../includes/db.php';

    $title = $_POST['title'];
    $content1 = $_POST['content1'];
    $content2 = $_POST['content2'];
    $brand_name = $_POST['brand_name'];
    $address = $_POST['address'];
    $mobile_number = $_POST['mobile_number'];
    $whatsapp_number = $_POST['whatsapp_number'];
    $email = $_POST['email'];
    $website_link = $_POST['website_link'];
    $content3 = $_POST['content3'];

    $image1 = '';
    if (isset($_FILES['image1']) && $_FILES['image1']['error'] == 0) {
        $image1 = '../uploads/' . basename($_FILES['image1']['name']);
        move_uploaded_file($_FILES['image1']['tmp_name'], $image1);
    }

    $image2 = '';
    if (isset($_FILES['image2']) && $_FILES['image2']['error'] == 0) {
        $image2 = '../uploads/' . basename($_FILES['image2']['name']);
        move_uploaded_file($_FILES['image2']['tmp_name'], $image2);
    }

    $image3 = '';
    if (isset($_FILES['image3']) && $_FILES['image3']['error'] == 0) {
        $image3 = '../uploads/' . basename($_FILES['image3']['name']);
        move_uploaded_file($_FILES['image3']['tmp_name'], $image3);
    }

    $stmt = $conn->prepare("INSERT INTO posts (title, content1, image1, content2, image2, brand_name, address, mobile_number, whatsapp_number, email, website_link, content3, image3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $title, $content1, $image1, $content2, $image2, $brand_name, $address, $mobile_number, $whatsapp_number, $email, $website_link, $content3, $image3);

    if ($stmt->execute()) {
        header("Location: posts.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<div class="container">
    <h2>Create Post</h2>
    <div class="form-container">
        <form action="create_post.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-section-title">Media & Content 1</div>
        <div class="form-group">
            <label for="image1">Image 1</label>
            <input type="file" name="image1" id="image1" class="form-control">
        </div>
        <div class="form-group">
            <label for="content1">Content 1</label>
            <textarea name="content1" id="content1" class="form-control" rows="5"></textarea>
        </div>

        <div class="form-section-title">Media & Content 2</div>
        <div class="form-group">
            <label for="image2">Image 2</label>
            <input type="file" name="image2" id="image2" class="form-control">
        </div>
        <div class="form-group">
            <label for="content2">Content 2</label>
            <textarea name="content2" id="content2" class="form-control" rows="5"></textarea>
        </div>

        <div class="form-section-title">Media & Content 3</div>
        <div class="form-group">
            <label for="image3">Image 3</label>
            <input type="file" name="image3" id="image3" class="form-control">
        </div>
        <div class="form-group">
            <label for="content3">Content 3</label>
            <textarea name="content3" id="content3" class="form-control" rows="5"></textarea>
        </div>

        <div class="form-section-title">Contact Information</div>
        <div class="form-row">
            <div class="form-group">
                <label for="brand_name">Brand Name</label>
                <input type="text" name="brand_name" id="brand_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="mobile_number">Mobile Number</label>
                <input type="text" name="mobile_number" id="mobile_number" class="form-control">
            </div>
            <div class="form-group">
                <label for="whatsapp_number">WhatsApp Number</label>
                <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="website_link">Website Link</label>
                <input type="text" name="website_link" id="website_link" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create Post</button>
            </form>
        </div>
    </div>
<?php include 'admin_footer.php'; ?>