<?php
require_once 'includes/db_connect.php';

// Handle product removal from cart
if (isset($_GET['remove'])) {
    $product_id = (int)$_GET['remove'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]); // Remove the product from the cart
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']); // Unset the cart if it's empty
        }
    }
    header('Location: /ajr_fashion/cart.php');
    exit;
}

$cart_items = [];
$total = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php require_once 'includes/header.php'; ?>

<main class="container mx-auto py-12">
    <h2 class="text-3xl font-bold text-center mb-8">Your Cart</h2>
    <?php if (empty($cart_items)): ?>
        <p class="text-center">Your cart is empty.</p>
    <?php else: ?>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4">Product</th>
                    <th class="p-4">Price</th>
                    <th class="p-4">Quantity</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <?php
                    $quantity = $_SESSION['cart'][$item['id']];
                    $subtotal = $item['price'] * $quantity;
                    $total += $subtotal;
                    ?>
                    <tr class="border-b">
                        <td class="p-4"><?php echo $item['name']; ?></td>
                        <td class="p-4">$<?php echo number_format($item['price'], 2); ?></td>
                        <td class="p-4"><?php echo $quantity; ?></td>
                        <td class="p-4">$<?php echo number_format($subtotal, 2); ?></td>
                        <td class="p-4">
                            <a href="/ajr_fashion/cart.php?remove=<?php echo $item['id']; ?>" 
                               class="text-red-600 hover:underline" 
                               onclick="return confirm('Are you sure you want to remove this item from your cart?');">
                                Remove
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-right mt-8">
            <p class="text-xl font-semibold">Total: $<?php echo number_format($total, 2); ?></p>
            <a href="/ajr_fashion/checkout.php" class="mt-4 inline-block btn bg-green-600 text-white px-6 py-3 rounded">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</main>

<?php require_once 'includes/footer.php'; ?>