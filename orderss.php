<!-- Inside order.php -->
<head>
  <style>
    .success-message {
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        margin: 20px auto;
        border: 1px solid #c3e6cb;
        border-radius: 8px;
        text-align: center;
        max-width: 400px;
    }
  </style>
</head>
<body>
  <?php if (isset($_GET['success'])): ?>
    <div class="success-message">Order placed successfully!</div>
  <?php endif; ?>
</body>
