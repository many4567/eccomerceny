<?php
// submit_order.php
require_once '../config/db.php';
$pdo = connectWithPDO();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['customer_name'];
    $email = $_POST['customer_email'];
    $phone = $_POST['phone'];
    $product = $_POST['product_name'];
    $price = $_POST['total_price'];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO orders (customer_name, customer_email, phone, product_name, total_price)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$name, $email, $phone, $product, $price]);

       // change this line
     echo "<script>alert('Order placed successfully!'); window.location.href='order.php';</script>";
       // to this (ONLY if you allow changes):
        header("Location: order.php?success=1");

    } catch (PDOException $e) {
        echo "Error saving order: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>

