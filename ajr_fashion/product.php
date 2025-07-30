<?php
require_once 'includes/db_connect.php';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<?php require_once 'includes/header.php'; ?>

<main class="container mx-auto py-12">
    <?php if ($product): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <img src="/ajr_fashion/<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-96 object-cover rounded-lg">
            </div>
            <div>
                <h1 class="text-3xl font-bold mb-4"><?php echo $product['name']; ?></h1>
                <p class="text-gray-600 mb-4"><?php echo $product['description']; ?></p>
                <p class="text-2xl font-semibold text-pink-600 mb-4">$<?php echo number_format($product['price'], 2); ?></p>
                <form action="/ajr_fashion/add_to_cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <label for="quantity" class="block mb-2">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" class="w-20 p-2 border rounded mb-4">
                    <button type="submit" class="btn bg-pink-600 text-white px-6 py-3 rounded">Add to Cart</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center text-red-600">Product not found.</p>
    <?php endif; ?>
</main>

<?php require_once 'includes/footer.php'; ?>