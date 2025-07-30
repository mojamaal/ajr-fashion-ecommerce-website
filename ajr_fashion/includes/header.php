<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJR Fashion</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ajr_fashion/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow sticky top-0 z-50">
        <nav class="container mx-auto flex items-center justify-between py-4">
            <a href="/ajr_fashion/index.php" class="text-2xl font-bold text-pink-600">AJR Fashion</a>
            <div class="flex items-center space-x-4">
                <a href="/ajr_fashion/index.php" class="text-gray-700 hover:text-pink-600">Home</a>
                <a href="/ajr_fashion/shop.php" class="text-gray-700 hover:text-pink-600">Shop</a>
                <a href="/ajr_fashion/about.php" class="text-gray-700 hover:text-pink-600">About</a>
                <a href="/ajr_fashion/contact.php" class="text-gray-700 hover:text-pink-600">Contact</a>
                <a href="/ajr_fashion/cart.php" class="text-gray-700 hover:text-pink-600"><i class="fas fa-shopping-cart"></i></a>
                 <a href="/ajr_fashion/register.php" class="text-gray-700 hover:text-pink-600">Register</a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php
                    $stmt = $pdo->prepare('SELECT is_admin FROM users WHERE id = ?');
                    $stmt->execute([$_SESSION['user_id']]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($user['is_admin'] == 1): ?>
                        <a href="/ajr_fashion/admin/index.php" class="text-gray-700 hover:text-pink-600">Admin Panel</a>
                    <?php endif; ?>
                    <a href="/ajr_fashion/logout.php" class="text-gray-700 hover:text-pink-600">Logout</a>
                <?php else: ?>
                    <a href="/ajr_fashion/login.php" class="text-gray-700 hover:text-pink-600">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>