<?php
include '../config/db.php';

$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];

$imagePath = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $targetDir = "../uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $fileName = time() . '_' . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $fileName;
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $imagePath = 'uploads/' . $fileName;
    }
}

$sql = "INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssds", $name, $description, $price, $imagePath);
$stmt->execute();

header("Location: ../index.php");
exit;
?>
