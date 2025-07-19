<!-- order.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
        }
        form {
            margin: 0 auto;
            width: 100%;
            max-width: 700px;
            background:rgb(43, 188, 255);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        input, button {
             
            width: 97%;
            margin: 10px 0;
            padding: 10px;
        }
        input {
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .success-message {
            background-color:rgb(69, 255, 112);
            color: #155724;
            padding: 15px;
            margin: 20px auto;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            text-align: center;
            max-width: 400px;
        }
     h4,h6{
         text-align: center;
            color: #333;
     }
        @media (max-width: 768px) {
    body {
        padding: 20px;
    }

    form {
        padding: 15px;
        width: 80%;
        max-width: 100%;
    }

    input, button {
        width: 90%;
        padding: 12px;
    }

    h2, h4, h6 {
        font-size: 1.2em;
        padding: 0 10px;
    }

    .success-message {
        max-width: 90%;
        font-size: 14px;
        padding: 10px;
    }
    
}

    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    <h2>Place Your Order</h2>
    <form action="api/order.php" method="POST">
        <input type="text" name="customer_name" placeholder="Your Name" required>
        <input type="email" name="customer_email" placeholder="Your Email" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="text" name="product_name" placeholder="Product Name" required>
        <input type="number" name="total_price" placeholder="Total Price" step="0.01" required>
        <button type="submit">Submit Order</button>
    </form>
    
    <div style="text-align: center; font-family: 'Khmer OS Battambang', sans-serif; padding: 40px;">
    <h2 style="color: #0d47a1;">សូមអរគុណ!</h2>
    <p style="font-size: 18px; color: #333;">
        សូមអរគុណចំពោះការជ្រើសរើសប្រើសេវាកម្ម/ផលិតផលរបស់យើង។<br>
        ការបញ្ជាទិញរបស់អ្នកត្រូវបានទទួលជោគជ័យ។<br>
        យើងនឹងទាក់ទងអ្នកវិញឆាប់ៗនេះ។
    </p>
    <a href="index.php" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #1976d2; color: white; text-decoration: none; border-radius: 5px;">
        ទៅគេហទំព័រដើម
    </a>
</div>
    <?php include 'footer.php'; ?>
</body>
</html>

