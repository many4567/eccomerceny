<?php
require_once __DIR__ . '/config/db.php';
$pdo = connectWithPDO(); // Connect to SQL Server

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $product = trim($_POST['product'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $message) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, product, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $product, $message]);
            $successMessage = "✅ Message sent successfully!";
        } catch (PDOException $e) {
            $errorMessage = "❌ Database error: " . $e->getMessage();
        }
    } else {
        $errorMessage = "⚠️ All fields except product are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; padding: 20px; }
        form {
            max-width: 700px; margin: auto; background: white;
            padding: 40px; border-radius: 8px;
            box-shadow: 0 1px 10px rgba(0, 102, 255, 0.1);
            height: 550px;
            justify-content: center;
            
        }
        input, textarea {
            width: 100%; padding: 10px; margin: 10px 0;
            border: 1px solid #ccc; border-radius: 4px;
            box-sizing: border-box; font-size: 1em;
        }
        button {
            background: #007bff; color: white;
            padding: 10px 15px; border: none;
            border-radius: 4px; cursor: pointer;
        }
        button:hover { background: #0056b3; }
        .msg {
            max-width: 550px; margin: 10px auto;
            padding: 10px; border-radius: 5px;
            text-align: center;
        }
        .success { background: #d4edda; color: #155724; }
        .error   { background: #f8d7da; color: #721c24; }
        h2{
            text-align: center; color: #333;
            margin-bottom: 50px; font-size: 1.8em;
        }
        
    </style>
</head>
<body>
<?php include 'nav.php'; ?>
<?php if ($successMessage): ?>
    <div class="msg success"><?= $successMessage ?></div>
<?php endif; ?>

<?php if ($errorMessage): ?>
    <div class="msg error"><?= $errorMessage ?></div>
<?php endif; ?>
<h2>Contact Us</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Your Name" required />
    <input type="email" name="email" placeholder="Your Email" required />
    <input type="text" name="product" placeholder="Product Name (optional)" />
    <textarea name="message" placeholder="Your Question" required></textarea>
    <button type="submit">Send</button>
</form>
<?php include 'footer.php'; ?>
</body>
</html>
