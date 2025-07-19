<?php
// filepath: c:\xampp\htdocs\ecommerce\api\update.php
include '../config/db.php';
$pdo = connectWithPDO();

$id = $_POST['id'];
$name = $_POST['name'];
$desc = $_POST['description'];
$price = $_POST['price'];
$image = $_POST['image'];

$sql = "UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$name, $desc, $price, $image, $id]);

header("Location: ../index.php");
exit;
?>
