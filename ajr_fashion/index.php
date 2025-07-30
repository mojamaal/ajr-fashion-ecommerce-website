<?php require_once 'includes/db_connect.php'; ?>
<?php require_once 'includes/header.php'; ?>

<main>
    <!-- Hero Section -->
    <section class="hero-section relative">
        <img src="/ajr_fashion/images/hero.jpg" alt="Hero" class="w-full h-96 object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="content text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">Welcome to AJR Fashion</h1>
                <p class="text-lg md:text-xl mb-6">Discover the latest trends in clothing.</p>
                <a href="/ajr_fashion/shop.php" class="btn bg-pink-600 text-white px-6 py-3 rounded-full">Shop Now</a>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="container mx-auto py-12">
        <h2 class="text-3xl font-bold text-center mb-8">Featured Products</h2>
        <div class="product-grid">
            <?php
            $stmt = $pdo->query('SELECT * FROM products LIMIT 3');
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
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>