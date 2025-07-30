<?php
require_once '../includes/db_connect.php';
checkAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AJR Fashion</title>
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
        <h2 class="text-3xl font-bold text-center mb-8">Admin Dashboard</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Quick Stats -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-2">Total Products</h3>
                <?php
                $stmt = $pdo->query('SELECT COUNT(*) FROM products');
                $total_products = $stmt->fetchColumn();
                ?>
                <p class="text-3xl text-pink-600"><?php echo $total_products; ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-2">Total Categories</h3>
                <?php
                $stmt = $pdo->query('SELECT COUNT(*) FROM categories');
                $total_categories = $stmt->fetchColumn();
                ?>
                <p class="text-3xl text-pink-600"><?php echo $total_categories; ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-2">Total Orders</h3>
                <?php
                $stmt = $pdo->query('SELECT COUNT(*) FROM orders');
                $total_orders = $stmt->fetchColumn();
                ?>
                <p class="text-3xl text-pink-600"><?php echo $total_orders; ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-2">Total Users</h3>
                <?php
                $stmt = $pdo->query('SELECT COUNT(*) FROM users');
                $total_users = $stmt->fetchColumn();
                ?>
                <p class="text-3xl text-pink-600"><?php echo $total_users; ?></p>
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto text-center">
            <p>© 2025 AJR Fashion. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>