<?php require_once 'includes/db_connect.php'; ?>
<?php require_once 'includes/header.php'; ?>

<main class="container mx-auto py-12">
    <h2 class="text-3xl font-bold text-center mb-8">Our Collection</h2>
    <!-- Filters -->
    <div class="flex justify-between mb-8">
        <select id="categoryFilter" class="p-2 border rounded">
            <option value="">All Categories</option>
            <?php
            $stmt = $pdo->query('SELECT * FROM categories');
            while ($category = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <input type="text" id="searchInput" placeholder="Search products..." class="p-2 border rounded">
    </div>
    <!-- Product Grid -->
    <div id="productGrid" class="product-grid">
        <?php
        $stmt = $pdo->query('SELECT * FROM products');
        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)):
        ?>
            <div class="product-card bg-white rounded-lg shadow">
                <img src="/ajr_fashion/<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-64 object-cover rounded-t-lg">
                <div class="p-4">
                    <h3 class="text-xl font-semibold"><?php echo $product['name']; ?></h3>
                    <p class="text-gray-600">$<?php echo number_format($product['price'], 2); ?></p>
                    <a href="/ajr_fashion/product.php?id=<?php echo $product['id']; ?>" class="mt-4 inline-block btn bg-pink-600 text-white px-4 py-2 rounded">View Details</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>