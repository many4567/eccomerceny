<?php
header('Content-Type: application/json');
include '../config/db.php';

$id = $_POST['id'] ?? 0;
$email = $_POST['email'] ?? '';
$customer_name = $_POST['customer_name'] ?? '';
$phone = $_POST['phone'] ?? '';
$product_name = $_POST['product_name'] ?? '';
$total_price = $_POST['total_price'] ?? 0;

if ($id && $email && $customer_name && $phone && $product_name && $total_price) {
    $stmt = $conn->prepare("UPDATE orders SET customer_name=?, phone=?, product_name=?, total_price=? WHERE id=? AND customer_email=?");
    $stmt->bind_param("ssssds", $customer_name, $phone, $product_name, $total_price, $id, $email);
    $stmt->execute();
    echo json_encode(['success' => true]);
    exit;
}
echo json_encode(['success' => false, 'error' => 'Missing fields']);
exit;
?>