<?php
include 'config/db.php';
$pdo = connectWithPDO();

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();
?>

<h2>Edit Product</h2>
<form action="api/update.php" method="POST">
  <input type="hidden" name="id" value="<?= $row['id'] ?>">
  <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required><br>
  <textarea name="description"><?= htmlspecialchars($row['description']) ?></textarea><br>
  <input type="number" name="price" value="<?= $row['price'] ?>" required><br>
  <input type="text" name="image" value="<?= htmlspecialchars($row['image']) ?>"><br>
  <button type="submit">Update Product</button>
</form>
