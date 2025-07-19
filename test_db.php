<!DOCTYPE html>
<html>
<head>
    <title>Database Connection Test</title>
    <style>
        body {
            background: #f2f2f2;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .message {
            padding: 20px 30px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            text-align: center;
        }
        .success {
            color: #155724;
            background-color: #d4edda;
            border: 2px solid #c3e6cb;
        }
        .fail {
            color: #721c24;
            background-color: #f8d7da;
            border: 2px solid #f5c6cb;
        }
    </style>
</head>
<body>

<div class="message">
    <?php
    require_once __DIR__ . "/config/db.php";
    try {
        connectWithPDO();
        echo '<div class="success">✅ Connected to SQL Server successfully!</div>';
    } catch (Exception $e) {
        echo '<div class="fail">❌ Connection failed: ' . $e->getMessage() . '</div>';
    }
    ?>
</div>

</body>
</html>
