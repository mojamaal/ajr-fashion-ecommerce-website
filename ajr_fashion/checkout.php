<?php require_once 'includes/db_connect.php'; ?>
<?php require_once 'includes/header.php'; ?>

<main class="container mx-auto py-12">
    <h2 class="text-3xl font-bold text-center mb-8">Checkout</h2>
    <form action="/ajr_fashion/process_order.php" method="post" class="checkout max-w-lg mx-auto">
        <div class="mb-4">
            <label for="name" class="block mb-2">Full Name</label>
            <input type="text" id="name" name="name" required class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="address" class="block mb-2">Shipping Address</label>
            <textarea id="address" name="address" required class="w-full p-2 border rounded"></textarea>
        </div>
        <div class="mb-4">
            <label for="payment" class="block mb-2">Payment Method</label>
            <select id="payment" name="payment" class="w-full p-2 border rounded">
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
            </select>
        </div>
        <button type="submit" class="btn bg-pink-600 text-white px-6 py-3 rounded">Complete Purchase</button>
    </form>
</main>

<?php require_once 'includes/footer.php'; ?>