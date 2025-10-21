<?php
require_once '../includes/db.php';

function upload_image($file, $target_dir = '../uploads/') {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $target_file = $target_dir . basename($file['name']);
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return 'uploads/' . basename($file['name']);
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? null;
    $content1 = $_POST['content1'] ?? null;
    $content2 = $_POST['content2'] ?? null;
    $brand_name = $_POST['brand_name'] ?? null;
    $address = $_POST['address'] ?? null;
    $mobile_number = $_POST['mobile_number'] ?? null;
    $whatsapp_number = $_POST['whatsapp_number'] ?? null;
    $email = $_POST['email'] ?? null;

    $image1 = isset($_FILES['image1']) ? upload_image($_FILES['image1']) : null;
    $image2 = isset($_FILES['image2']) ? upload_image($_FILES['image2']) : null;
    $image3 = isset($_FILES['image3']) ? upload_image($_FILES['image3']) : null;

    $stmt = $conn->prepare("INSERT INTO posts (title, image1, content1, image2, content2, image3, brand_name, address, mobile_number, whatsapp_number, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssssssss', $title, $image1, $content1, $image2, $content2, $image3, $brand_name, $address, $mobile_number, $whatsapp_number, $email);

    if ($stmt->execute()) {
        header('Location: posts.php');
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>