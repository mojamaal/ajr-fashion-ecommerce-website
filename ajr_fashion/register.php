<?php
require_once 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($username) < 3) {
        $error = 'Username must be at least 3 characters long.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $error = 'Email is already registered. Please use a different email.';
        } else {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
            $stmt->execute([$username]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                $error = 'Username is already taken. Please choose a different username.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)');
                try {
                    $stmt->execute([$username, $email, $hashedPassword, 0]);
                    header('Location: /ajr_fashion/admin/login.php?success=Registration successful. Please log in.');
                    exit;
                } catch (PDOException $e) {
                    $error = 'Registration failed: ' . $e->getMessage();
                }
            }
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<main class="container mx-auto py-12">
    <h2 class="text-3xl font-bold text-center mb-8">Register</h2>
    <?php if (isset($error)): ?>
        <p class="text-red-600 text-center"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <p class="text-green-600 text-center"><?php echo $_GET['success']; ?></p>
    <?php endif; ?>
    <form action="/ajr_fashion/register.php" method="post" class="checkout max-w-lg mx-auto">
        <div class="mb-4">
            <label for="username" class="block mb-2">Username</label>
            <input type="text" id="username" name="username" required class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="email" class="block mb-2">Email</label>
            <input type="email" id="email" name="email" required class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="password" class="block mb-2">Password</label>
            <input type="password" id="password" name="password" required class="w-full p-2 border rounded">
        </div>
        <button type="submit" class="btn bg-pink-600 text-white px-6 py-3 rounded">Register</button>
    </form>
    <p class="text-center mt-4">
        Already have an account? <a href="/ajr_fashion/admin/login.php" class="text-blue-600">Log in</a>
    </p>
</main>
<?php include 'includes/footer.php'; ?>