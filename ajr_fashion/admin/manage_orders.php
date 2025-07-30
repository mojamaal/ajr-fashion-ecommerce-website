<?php
require_once '../includes/db_connect.php';
checkAdmin();

// Handle order status update
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
    $stmt->execute([$status, $order_id]);
    header('Location: /ajr_fashion/admin/manage_orders.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - AJR Fashion</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ajr_fashion/css/styles.css">
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow sticky top-0 z-50">
        <nav class="container mx-auto flex items-center justify-between py-4">
            <a href="/ajr_fashion/index.php" class="text-2xl font-bold text-pink-600">AJR Fashion</a>
            <div class="flex items-center space-x-4">
                <a href="/ajr_fashion/admin/index.php" class="text-gray-700 hover:text-pink-600">Dashboard</a>
                <a href="/ajr_fashion/admin/manage_products.php" class="text-gray-700 hover:text-pink-600">Products</a>
                <a href="/ajr_fashion/admin/manage_categories.php" class="text-gray-700 hover:text-pink-600">Categories</a>
                <a href="/ajr_fashion/admin/manage_orders.php" class="text-gray-700 hover:text-pink-600">Orders</a>
                <a href="/ajr_fashion/admin/manage_users.php" class="text-gray-700 hover:text-pink-600">Users</a>
                <a href="/ajr_fashion/logout.php" class="text-gray-700 hover:text-pink-600">Logout</a>
            </div>
        </nav>
    </header>

    <main class="container mx-auto py-12">
        <h2 class="text-3xl font-bold text-center mb-8">Manage Orders</h2>

        <!-- Order List -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-2xl font-semibold mb-4">Order List</h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-4">Order ID</th>
                        <th class="p-4">User ID</th>
                        <th class="p-4">Total Amount</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Created At</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query('SELECT * FROM orders');
                    while ($order = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                        <tr class="border-b">
                            <td class="p-4"><?php echo $order['id']; ?></td>
                            <td class="p-4"><?php echo $order['user_id'] ?: 'Guest'; ?></td>
                            <td class="p-4">$<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td class="p-4"><?php echo $order['status']; ?></td>
                            <td class="p-4"><?php echo $order['created_at']; ?></td>
                            <td class="p-4">
                                <form action="/ajr_fashion/admin/manage_orders.php" method="post" class="inline">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" class="p-2 border rounded">
                                        <option value="pending" <?php if ($order['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                        <option value="processing" <?php if ($order['status'] == 'processing') echo 'selected'; ?>>Processing</option>
                                        <option value="shipped" <?php if ($order['status'] == 'shipped') echo 'selected'; ?>>Shipped</option>
                                        <option value="delivered" <?php if ($order['status'] == 'delivered') echo 'selected'; ?>>Delivered</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn bg-pink-600 text-white px-4 py-2 rounded ml-2">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto text-center">
            <p>© 2025 AJR Fashion. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>