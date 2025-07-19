<?php
include 'config/db.php';
$pdo = connectWithPDO();

// Example query:
$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$results = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
   <style>
    h1 {
        text-align: center;
        margin-top: 20px;
        color: #333;
    }
    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Default: 4 columns */
        gap: 20px;
        padding: 10px;
    }

    .product-card {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        text-align: center;
        background-color: #f9f9f9;
    }

    .product-card h2 {
        font-size: 1.5em;
        margin-bottom: 10px;
    }

    .product-card .price {
        color: green;
        font-weight: bold;
    }

    .product-card .desc {
        font-size: 0.9em;
        color: #555;
    }

    .product-card img {
        width: 80%;
        height: auto;
        border-radius: 5px;
    }
    .product-card img:hover {
        transform: scale(1.07);
        transition: transform 0.3s ease;
    }
    .add-to-cart{
    border-radius: 16px;
    padding: 10px 20px;
    text-decoration: none;
    display: inline-block;
    margin-top: 10px;
    background-color:rgb(173, 173, 173);
}
    .add-to-cart:hover {
        background-color: #007bff;
        color: white;
    }


    /* Responsive: 2 columns on tablets */
    @media (max-width: 992px) {
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Responsive: 1 column on mobile */
    @media (max-width: 576px) {
        .products-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

</head>
<body>
<?php include 'nav.php'; ?>
<h1>Product List</h1>
<div class="products-grid">
<?php
foreach ($results as $row) {
    echo "<div class='product-card'>";
    echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
    echo "<p class='price'>Price: $" . htmlspecialchars($row['price']) . "</p>";
    echo "<p class='desc'>" . htmlspecialchars($row['description']) . "</p>";
    echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' width='100'>";
    echo "<a href='order.php?id=" . urlencode($row['id']) . "' class='add-to-cart-btn'><button class='add-to-cart'>Add to Cart</button></a>";

    echo "</div>";
}
?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
