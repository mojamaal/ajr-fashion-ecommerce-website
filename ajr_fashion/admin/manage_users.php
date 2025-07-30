<?php
require_once '../includes/db_connect.php';
checkAdmin();

// Handle user deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: /ajr_fashion/admin/manage_users.php');
    exit;
}

// Handle toggle admin status
if (isset($_GET['toggle_admin'])) {
    $id = $_GET['toggle_admin'];
    $stmt = $pdo->prepare('UPDATE users SET is_admin = IF(is_admin = 1, 0, 1) WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: /ajr_fashion/admin/manage_users.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - AJR Fashion</title>
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
        <h2 class="text-3xl font-bold text-center mb-8">Manage Users</h2>

        <!-- User List -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-2xl font-semibold mb-4">User List</h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-4">ID</th>
                        <th class="p-4">Username</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Admin</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query('SELECT * FROM users');
                    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                        <tr class="border-b">
                            <td class="p-4"><?php echo $user['id']; ?></td>
                            <td class="p-4"><?php echo $user['username']; ?></td>
                            <td class="p-4"><?php echo $user['email']; ?></td>
                            <td class="p-4"><?php echo $user['is_admin'] ? 'Yes' : 'No'; ?></td>
                            <td class="p-4">
                                <a href="/ajr_fashion/admin/manage_users.php?toggle_admin=<?php echo $user['id']; ?>" class="text-blue-600 hover:underline mr-2">
                                    <?php echo $user['is_admin'] ? 'Remove Admin' : 'Make Admin'; ?>
                                </a>
                                <a href="/ajr_fashion/admin/manage_users.php?delete=<?php echo $user['id']; ?>" class="text-red-600 hover:underline">Delete</a>
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