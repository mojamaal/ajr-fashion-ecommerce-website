<?php
require_once 'includes/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $total = 0;
    foreach ($_SESSION['cart'] as $id => $quantity) {
        $stmt = $pdo->prepare('SELECT price FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $total += $product['price'] * $quantity;
    }
    $stmt = $pdo->prepare('INSERT INTO orders (user_id, total_amount) VALUES (?, ?)');
    $stmt->execute([$user_id, $total]);
    $order_id = $pdo->lastInsertId();
    foreach ($_SESSION['cart'] as $id => $quantity) {
        $stmt = $pdo->prepare('SELECT price FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
        $stmt->execute([$order_id, $id, $quantity, $product['price']]);
    }
    unset($_SESSION['cart']);
    header('Location: /ajr_fashion/index.php');
    exit;
}
?>