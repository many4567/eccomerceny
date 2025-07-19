<?php
require_once '../config/db.php';
$pdo = connectWithPDO(); // Connect to SQL Server

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $product = trim($_POST['product'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate required fields
    if ($name === '' || $email === '' || $message === '') {
        echo json_encode(['success' => false, 'error' => 'Missing fields']);
        exit;
    }

    try {
        // Insert into SQL Server
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, product, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $product, $message]);

        echo json_encode(['success' => true, 'message' => 'Thank you for your question!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
    exit;

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get email from query string
    $email = trim($_GET['email'] ?? '');

    if ($email === '') {
        echo json_encode(['success' => false, 'error' => 'Email is required.']);
        exit;
    }

    try {
        // Fetch questions/answers for that email
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE email = ? ORDER BY created_at DESC");
        $stmt->execute([$email]);
        $contacts = $stmt->fetchAll();

        echo json_encode(['success' => true, 'data' => $contacts]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
    exit;

} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    exit;
}
