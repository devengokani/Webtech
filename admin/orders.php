<?php
$page_title = 'Admin - Orders';
include 'admin_header.php';

// Fetch orders from the database
$result = $conn->query("SELECT o.*, p.name AS product_name FROM orders o JOIN products p ON o.product_id = p.id ORDER BY o.ordered_at DESC");
$orders = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

?>

<div class="container">
    <header class="hero">
        <h1>Admin - Product Orders</h1>
    </header>

    <div class="admin-section">
        <h2>Received Orders</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Ordered At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['name']); ?></td>
                        <td><?php echo htmlspecialchars($order['email']); ?></td>
                        <td><?php echo htmlspecialchars($order['address']); ?></td>
                        <td><?php echo $order['ordered_at']; ?></td>
                        <td class="actions">
                            <a href="../<?php echo $order['screenshot']; ?>" class="btn" target="_blank">View Screenshot</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
