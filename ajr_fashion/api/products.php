<?php
require_once '../includes/db_connect.php';
$category = isset($_GET['category']) ? (int)$_GET['category'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = 'SELECT * FROM products WHERE 1=1';
$params = [];
if ($category) {
    $query .= ' AND category_id = ?';
    $params[] = $category;
}
if ($search) {
    $query .= ' AND name LIKE ?';
    $params[] = '%' . $search . '%';
}
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($products);
?>