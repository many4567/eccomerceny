<?php
require_once './config/db.php';
$pdo = connectWithPDO();

// Initialize variables
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $price = $_POST['price'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $id = $_POST['id'] ?? null;
    $imageName = '';

    // Validate required fields for insert/update
    if (($action === 'insert' || $action === 'update') && (empty($name) || empty($price) || empty($description))) {
        $message = 'All fields are required.';
        $messageType = 'error';
    } else {
        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $targetDir = "uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Get file extension
            $fileExtension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $imageName = uniqid() . '.' . $fileExtension;
            $targetFile = $targetDir . $imageName;

            // Check file size (limit to 5MB)
            if ($_FILES['image']['size'] > 5000000) {
                $message = 'File size is too large. Maximum size is 5MB.';
                $messageType = 'error';
            } else {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                
                // Check file type and extension
                if (function_exists('mime_content_type')) {
                    $fileType = mime_content_type($_FILES['image']['tmp_name']);
                } else {
                    $fileType = $_FILES['image']['type'];
                }
                
                if (in_array($fileType, $allowedTypes) && in_array($fileExtension, $allowedExtensions)) {
                    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                        $message = 'Failed to upload image.';
                        $messageType = 'error';
                    }
                } else {
                    $message = 'Only JPG, JPEG, PNG, GIF, and WebP files are allowed.';
                    $messageType = 'error';
                }
            }
        }

        // Process actions only if no upload errors
        if ($messageType !== 'error') {
            try {
                if ($action === 'insert') {
                    $stmt = $pdo->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$name, $price, $description, $imageName]);
                    $message = 'Product inserted successfully!';
                    $messageType = 'success';
                    
                } elseif ($action === 'update' && $id) {
                    if ($imageName) {
                        // Delete old image before updating
                        $oldImageStmt = $pdo->prepare("SELECT image FROM products WHERE id=?");
                        $oldImageStmt->execute([$id]);
                        $oldImage = $oldImageStmt->fetchColumn();
                        if ($oldImage && file_exists("uploads/" . $oldImage)) {
                            unlink("uploads/" . $oldImage);
                        }
                        
                        $stmt = $pdo->prepare("UPDATE products SET name=?, price=?, description=?, image=? WHERE id=?");
                        $stmt->execute([$name, $price, $description, $imageName, $id]);
                    } else {
                        $stmt = $pdo->prepare("UPDATE products SET name=?, price=?, description=? WHERE id=?");
                        $stmt->execute([$name, $price, $description, $id]);
                    }
                    $message = 'Product updated successfully!';
                    $messageType = 'success';
                    
                } elseif ($action === 'delete' && $id) {
                    // Delete associated image file before deleting record
                    $imageStmt = $pdo->prepare("SELECT image FROM products WHERE id=?");
                    $imageStmt->execute([$id]);
                    $image = $imageStmt->fetchColumn();
                    if ($image && file_exists("uploads/" . $image)) {
                        unlink("uploads/" . $image);
                    }
                    
                    $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
                    $stmt->execute([$id]);
                    $message = 'Product deleted successfully!';
                    $messageType = 'success';
                }
            } catch (PDOException $e) {
                $message = 'Database error: ' . $e->getMessage();
                $messageType = 'error';
            }
        }
    }
}

// Fetch all products for display
try {
    $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
    $stmt->execute();
    $result = $stmt->fetchAll();
} catch (PDOException $e) {
    $message = 'Error fetching products: ' . $e->getMessage();
    $messageType = 'error';
    $result = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Product Management</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        nav {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        nav .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }
        
        nav a {
            color: #fff;
            margin: 0 20px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 25px;
        }
        
        nav a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        
        h1 {
            text-align: center;
            color: #2c3e50;
            margin: 30px 0;
            font-size: 2.5em;
            font-weight: 300;
        }
        
        .message {
            max-width: 600px;
            margin: 20px auto;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
        }
        
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .form-container {
            background: #fff;
            max-width: 600px;
            margin: 40px auto;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
        }
        
        input, textarea, select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .products-section {
            margin-top: 60px;
        }
        
        .section-title {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 2em;
            font-weight: 400;
        }
        
        .products-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .products-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 20px 15px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .products-table td {
            padding: 20px 15px;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
        }
        
        .products-table tr:hover {
            background: #f8f9fa;
        }
        
        .products-table img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }
        
        .action-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 5px;
        }
        
        .edit-btn {
            background: #28a745;
            color: #fff;
        }
        
        .edit-btn:hover {
            background: #218838;
            transform: translateY(-1px);
        }
        
        .delete-btn {
            background: #dc3545;
            color: #fff;
        }
        
        .delete-btn:hover {
            background: #c82333;
            transform: translateY(-1px);
        }
        
        .no-image {
            color: #6c757d;
            font-style: italic;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .empty-state h3 {
            margin-bottom: 10px;
            color: #495057;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .form-container {
                margin: 20px auto;
                padding: 20px;
            }
            
            .products-table {
                font-size: 14px;
            }
            
            .products-table th,
            .products-table td {
                padding: 10px 8px;
            }
            
            .products-table img {
                width: 60px;
                height: 60px;
            }
             nav .nav-content {
             flex-direction: column;
             text-align: center;
          }

           nav a {
           display: block;
           margin: 10px auto;
           font-size: 14px;
           padding: 10px;
    }

    h1 {
        font-size: 1.8em;
        margin: 20px 10px;
        padding: 0 10px;
    }
        }
        @media (max-width: 600px) {
    .products-table th,
    .products-table td {
        font-size: 12px;
        padding: 8px;
    }

    .products-table img {
        width: 50px;
        height: 50px;
    }

    .products-table td:nth-child(5) {
        max-width: 150px;
        overflow-wrap: break-word;
    }

    .action-btn {
        font-size: 12px;
        padding: 6px 12px;
        margin: 3px 0;
    }

    .products-table th:nth-child(1),
    .products-table td:nth-child(1) {
        display: none; /* Hide ID column on small screens */
    }
}

    </style>
</head>
<body>
    <nav>
        <div class="nav-content">
            <a href="admin.php">Product Management</a>
            <a href="admin_contacts.php">Customer Support</a>
            <a href="prducts.php">View Products</a>
        </div>
    </nav>
    
    <div class="container">
        <h1>Product Management System</h1>
        
        <?php if ($message): ?>
            <div class="message <?= $messageType ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <!-- Admin Form -->
        <div class="form-container">
            <form method="POST" enctype="multipart/form-data" id="productForm">
                <input type="hidden" name="id" id="product-id">
                
                <div class="form-group">
                    <label for="name">Product Name *</label>
                    <input type="text" name="name" id="name" placeholder="Enter product name" required>
                </div>
                
                <div class="form-group">
                    <label for="price">Price ($) *</label>
                    <input type="number" name="price" id="price" step="0.01" min="0" placeholder="0.00" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea name="description" id="description" placeholder="Enter product description" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif,image/webp">
                    <small style="color: #6c757d; font-size: 12px;">Supported formats: JPG, PNG, GIF, WebP. Max size: 5MB</small>
                </div>
                
                <div class="form-group">
                    <label for="action">Action *</label>
                    <select name="action" id="action" required>
                        <option value="insert">Add New Product</option>
                        <option value="update">Update Product</option>
                        <option value="delete">Delete Product</option>
                    </select>
                </div>
                
                <button type="submit" class="submit-btn">Execute Action</button>
            </form>
        </div>

        <div class="products-section">
            <h2 class="section-title">Current Products</h2>
            
            <?php if (empty($result)): ?>
                <div class="empty-state">
                    <h3>No products found</h3>
                    <p>Start by adding your first product using the form above.</p>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($row['id']) ?></strong></td>
                                <td>
                                    <?php if (!empty($row['image'])): ?>
                                        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                                    <?php else: ?>
                                        <span class="no-image">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= htmlspecialchars($row['name']) ?></strong></td>
                                <td><strong>$<?= number_format($row['price'], 2) ?></strong></td>
                                <td><?= htmlspecialchars(substr($row['description'], 0, 100)) ?><?= strlen($row['description']) > 100 ? '...' : '' ?></td>
                                <td>
                                    <button type="button" class="action-btn edit-btn"
                                        onclick="editProduct(
                                            '<?= htmlspecialchars($row['id']) ?>',
                                            '<?= htmlspecialchars($row['name'], ENT_QUOTES) ?>',
                                            '<?= htmlspecialchars($row['price']) ?>',
                                            '<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>'
                                        )">Edit</button>
                                    <button type="button" class="action-btn delete-btn" 
                                        onclick="deleteProduct('<?= htmlspecialchars($row['id']) ?>')">Delete</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function editProduct(id, name, price, description) {
            document.getElementById('product-id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('price').value = price;
            document.getElementById('description').value = description;
            document.getElementById('action').value = "update";
            
            // Scroll to form
            document.querySelector('.form-container').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            
            // Focus on name field
            setTimeout(() => {
                document.getElementById('name').focus();
            }, 500);
        }
        
        function deleteProduct(id) {
            if(confirm('⚠️ Are you sure you want to delete this product?\n\nThis action cannot be undone and will permanently remove the product and its image.')) {
                document.getElementById('product-id').value = id;
                document.getElementById('action').value = "delete";
                document.getElementById('productForm').submit();
            }
        }
        
        // Reset form when changing action to insert
        document.getElementById('action').addEventListener('change', function() {
            if (this.value === 'insert') {
                document.getElementById('productForm').reset();
                document.getElementById('product-id').value = '';
                document.getElementById('action').value = 'insert';
            }
        });
        
        // Form validation
        document.getElementById('productForm').addEventListener('submit', function(e) {
            const action = document.getElementById('action').value;
            const name = document.getElementById('name').value.trim();
            const price = document.getElementById('price').value;
            const description = document.getElementById('description').value.trim();
            
            if (action === 'insert' || action === 'update') {
                if (!name || !price || !description) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                    return;
                }
                
                if (parseFloat(price) < 0) {
                    e.preventDefault();
                    alert('Price must be a positive number.');
                    return;
                }
            }
            
            if (action === 'delete') {
                if (!document.getElementById('product-id').value) {
                    e.preventDefault();
                    alert('Please select a product to delete.');
                    return;
                }
            }
        });
        
        // Auto-hide messages after 5 seconds
        const message = document.querySelector('.message');
        if (message) {
            setTimeout(() => {
                message.style.opacity = '0';
                setTimeout(() => {
                    message.remove();
                }, 300);
            }, 5000);
        }
    </script>
</body>
</html>