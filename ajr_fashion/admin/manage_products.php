<?php
require_once '../includes/db_connect.php';
checkAdmin();

// Handle product creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $stock = $_POST['stock'];
    $image_url = 'images/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image_url);
    $stmt = $pdo->prepare('INSERT INTO products (name, description, price, category_id, image_url, stock) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$name, $description, $price, $category_id, $image_url, $stock]);
    header('Location: /ajr_fashion/admin/manage_products.php');
    exit;
}

// Handle product update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $stock = $_POST['stock'];

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image_url = 'images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image_url);
    } else {
        // Keep the existing image if no new one is uploaded
        $stmt = $pdo->prepare('SELECT image_url FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $image_url = $product['image_url'];
    }

    $stmt = $pdo->prepare('UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, image_url = ?, stock = ? WHERE id = ?');
    $stmt->execute([$name, $description, $price, $category_id, $image_url, $stock, $id]);
    header('Location: /ajr_fashion/admin/manage_products.php');
    exit;
}

// Handle product deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: /ajr_fashion/admin/manage_products.php');
    exit;
}

// Fetch product details for editing
$edit_product = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $edit_product = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - AJR Fashion</title>
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
        <h2 class="text-3xl font-bold text-center mb-8">Manage Products</h2>

        <!-- Edit Product Form (shown only if editing) -->
        <?php if ($edit_product): ?>
            <form action="/ajr_fashion/admin/manage_products.php" method="post" enctype="multipart/form-data" class="checkout max-w-lg mx-auto mb-12">
                <input type="hidden" name="id" value="<?php echo $edit_product['id']; ?>">
                <div class="mb-4">
                    <label for="name" class="block mb-2">Product Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($edit_product['name']); ?>" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="description" class="block mb-2">Description</label>
                    <textarea id="description" name="description" class="w-full p-2 border rounded"><?php echo htmlspecialchars($edit_product['description']); ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="price" class="block mb-2">Price</label>
                    <input type="number" id="price" name="price" step="0.01" value="<?php echo $edit_product['price']; ?>" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block mb-2">Category</label>
                    <select id="category_id" name="category_id" required class="w-full p-2 border rounded">
                        <?php
                        $stmt = $pdo->query('SELECT * FROM categories');
                        while ($category = $stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $edit_product['category_id']) echo 'selected'; ?>>
                                <?php echo $category['name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="stock" class="block mb-2">Stock</label>
                    <input type="number" id="stock" name="stock" value="<?php echo $edit_product['stock']; ?>" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="image" class="block mb-2">Product Image (Leave blank to keep current image)</label>
                    <input type="file" id="image" name="image" class="w-full p-2 border rounded">
                    <p class="text-sm text-gray-600 mt-1">Current Image: <?php echo $edit_product['image_url']; ?></p>
                </div>
                <button type="submit" name="update_product" class="btn bg-pink-600 text-white px-6 py-3 rounded">Update Product</button>
                <a href="/ajr_fashion/admin/manage_products.php" class="ml-4 text-blue-600 hover:underline">Cancel</a>
            </form>
        <?php else: ?>
            <!-- Add Product Form -->
            <form action="/ajr_fashion/admin/manage_products.php" method="post" enctype="multipart/form-data" class="checkout max-w-lg mx-auto mb-12">
                <div class="mb-4">
                    <label for="name" class="block mb-2">Product Name</label>
                    <input type="text" id="name" name="name" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="description" class="block mb-2">Description</label>
                    <textarea id="description" name="description" class="w-full p-2 border rounded"></textarea>
                </div>
                <div class="mb-4">
                    <label for="price" class="block mb-2">Price</label>
                    <input type="number" id="price" name="price" step="0.01" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block mb-2">Category</label>
                    <select id="category_id" name="category_id" required class="w-full p-2 border rounded">
                        <?php
                        $stmt = $pdo->query('SELECT * FROM categories');
                        while ($category = $stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="stock" class="block mb-2">Stock</label>
                    <input type="number" id="stock" name="stock" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="image" class="block mb-2">Product Image</label>
                    <input type="file" id="image" name="image" required class="w-full p-2 border rounded">
                </div>
                <button type="submit" name="add_product" class="btn bg-pink-600 text-white px-6 py-3 rounded">Add Product</button>
            </form>
        <?php endif; ?>

        <!-- Product List -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-2xl font-semibold mb-4">Product List</h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-4">ID</th>
                        <th class="p-4">Name</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Stock</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query('SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id');
                    while ($product = $stmt->fetch(PDO::FETCH_ASSOC)):
                    ?>
                        <tr class="border-b">
                            <td class="p-4"><?php echo $product['id']; ?></td>
                            <td class="p-4"><?php echo $product['name']; ?></td>
                            <td class="p-4">$<?php echo number_format($product['price'], 2); ?></td>
                            <td class="p-4"><?php echo $product['category_name']; ?></td>
                            <td class="p-4"><?php echo $product['stock']; ?></td>
                            <td class="p-4">
                                <a href="/ajr_fashion/admin/manage_products.php?edit=<?php echo $product['id']; ?>" class="text-blue-600 hover:underline mr-2">Edit</a>
                                <a href="/ajr_fashion/admin/manage_products.php?delete=<?php echo $product['id']; ?>" class="text-red-600 hover:underline">Delete</a>
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