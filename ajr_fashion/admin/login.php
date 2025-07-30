<?php
require_once '../includes/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        if ($user['is_admin'] == 1) {
            header('Location: /ajr_fashion/admin/index.php');
        } else {
            header('Location: /ajr_fashion/index.php');
        }
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - AJR Fashion</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/ajr_fashion/css/styles.css">
</head>

<body class="bg-gray-100">
    <main class="container mx-auto py-12">
        <h2 class="text-3xl font-bold text-center mb-8">Admin Login</h2>
        <?php if (isset($error)): ?>
            <p class="text-red-600 text-center"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="/ajr_fashion/admin/login.php" method="post" class="checkout max-w-lg mx-auto">
            <div class="mb-4">
                <label for="email" class="block mb-2">Email</label>
                <input type="email" id="email" name="email" required class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="password" class="block mb-2">Password</label>
                <input type="password" id="password" name="password" required class="w-full p-2 border rounded">
            </div>
            <button type="submit" class="btn bg-pink-600 text-white px-6 py-3 rounded">Login</button>
        </form>
    </main>
</body>
</html>