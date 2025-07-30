<?php
session_start();
$dsn = 'mysql:host=localhost;dbname=ajr_fashion';
$username = 'root'; // Update with your MySQL username
$password = ''; // Update with your MySQL password

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Function to check if the user is an admin
function checkAdmin() {
    global $pdo;
    if (!isset($_SESSION['user_id'])) {
        header('Location: /ajr_fashion/admin/login.php');
        exit;
    }
    $stmt = $pdo->prepare('SELECT is_admin FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user || $user['is_admin'] != 1) {
        header('Location: /ajr_fashion/index.php');
        exit;
    }
}
?>