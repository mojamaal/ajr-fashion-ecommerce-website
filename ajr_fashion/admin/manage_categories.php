<?php
require_once '../includes/db_connect.php';
checkAdmin();

// Handle category creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = $_POST['name'];
    $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
    $stmt->execute([$name]);
    header('Location: /ajr_fashion/admin/manage_categories.php');
    exit;
}

// Handle category deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: /ajr_fashion/admin/manage_categories.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - AJR Fashion</title>
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
        <h2 class="text-3xl font-bold text-center mb-8">Manage Categories</h2>

        <!-- Add Category Form -->
        <form action="/ajr_fashion/admin/manage_categories.php" method="post" class="checkout max-w-lg mx-auto mb-12">
            <div class="mb-4">
                <label for="name" class="block mb-2">Category Name</label>
                <input type="text" id="name" name="name" required class="w-full p-2 border rounded">
            </div>
            <button type="submit" name="add_category" class="btn bg-pink-600 text-white px-6 py-3 rounded">Add Category</button>
        </form>

        <!-- Category List -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-2xl font-semibold mb-4">Category List</h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-4">ID</th>
                        <th class="p-4">Name</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query('SELECT * FROM categories');
                    while ($category = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                        <tr class="border-b">
                            <td class="p-4"><?php echo $category['id']; ?></td>
                            <td class="p-4"><?php echo $category['name']; ?></td>
                            <td class="p-4">
                                <a href="/ajr_fashion/admin/manage_categories.php?delete=<?php echo $category['id']; ?>" class="text-red-600 hover:underline">Delete</a>
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