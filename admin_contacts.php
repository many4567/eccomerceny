<?php
$lifetime = 60; // 1 minute
session_set_cookie_params($lifetime);
session_start();
include 'config/db.php';

$pdo = connectWithPDO();

$admin_password = '12345'; // Change this to your desired password

// Handle login
if (isset($_POST['admin_login'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['is_admin'] = true;
        $_SESSION['admin_name'] = $_POST['admin_name']; 
        header("Location: admin_contacts.php");
        exit;
    } else {
        $login_error = "Incorrect password!";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin_contacts.php");
    exit;
}

// Show login form if not logged in
if (empty($_SESSION['is_admin'])):
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        .login-box { max-width: 350px; margin: 100px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px #0001; }
        input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 4px; border: 1px solid #ccc; }
        button { padding: 10px 15px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if (!empty($login_error)) echo "<div style='color:red;'>$login_error</div>"; ?>
        <form method="POST">
            <input type="text" name="admin_name" placeholder="Your Name" required>
            <input type="password" name="password" placeholder="Admin Password" required>
            <button type="submit" name="admin_login">Login</button>
        </form>
        
        <!-- Debug: Show if we have session data -->
        <?php if (isset($_SESSION['admin_name'])): ?>
            <p style="color: green; font-size: 12px;">Debug: Session admin_name = <?= htmlspecialchars($_SESSION['admin_name']) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
exit;
endif;

// --- PDO version for SQL Server ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Debug: Show what we received
    error_log("POST data received:");
    error_log("ID: " . ($_POST['id'] ?? 'not set'));
    error_log("Answer: " . ($_POST['admin_answer'] ?? 'not set'));
    error_log("Session admin_name: " . ($_SESSION['admin_name'] ?? 'not set'));
    
    $id = (int)($_POST['id'] ?? 0);
    $answer = trim($_POST['admin_answer'] ?? '');
    $admin_name = trim($_SESSION['admin_name'] ?? '');
    
    // Debug validation
    $errors = [];
    if (!$id) $errors[] = "ID is missing or invalid: " . $id;
    if (empty($answer)) $errors[] = "Answer is empty";
    if (empty($admin_name)) $errors[] = "Admin name is empty from session";
    
    if (!empty($errors)) {
        error_log("Validation errors: " . implode(", ", $errors));
        // Don't redirect, show errors to user
        $update_error = "Error saving: " . implode(", ", $errors);
    } else {
        try {
            // Check if record exists first
            $check_stmt = $pdo->prepare("SELECT id FROM contacts WHERE id = ?");
            $check_stmt->execute([$id]);
            
            if (!$check_stmt->fetch()) {
                $update_error = "Contact with ID $id not found in database";
                error_log("Contact with ID $id not found");
            } else {
                // Record exists, proceed with update
                $stmt = $pdo->prepare("UPDATE contacts SET admin_answer=?, admin_name=? WHERE id=?");
                $result = $stmt->execute([$answer, $admin_name, $id]);
                
                if ($result) {
                    $affected_rows = $stmt->rowCount();
                    error_log("Update successful. Affected rows: " . $affected_rows);
                    
                    if ($affected_rows > 0) {
                        $_SESSION['success_message'] = "Answer saved successfully!";
                    } else {
                        $update_error = "No rows were updated. The record might not exist.";
                    }
                } else {
                    $update_error = "Database update failed";
                    error_log("Database update failed");
                }
            }
            
        } catch (PDOException $e) {
            $update_error = "Database error: " . $e->getMessage();
            error_log("Database error: " . $e->getMessage());
        }
        
        // Only redirect if successful
        if (!isset($update_error)) {
            header("Location: admin_contacts.php");
            exit;
        }
    }
}

// Debug: Check if we can connect to database and fetch results
try {
    $stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
    $results = $stmt->fetchAll();
    
    // Debug output - remove this after testing
    echo "<!-- DEBUG: Found " . count($results) . " records -->";
    
} catch (PDOException $e) {
    // Debug output - remove this after testing
    echo "<!-- DEBUG ERROR: " . $e->getMessage() . " -->";
    $results = [];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin: Answer Questions</title>
    <style>
body { font-family: Arial, sans-serif; background: #f4f4f4; }
h2 { text-align: center; color: #333; }
table { width: 98%; margin: 20px auto; border-collapse: collapse; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px #0001; }
th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
th { background: #e9ecef; }
tr:nth-child(even) { background: #f9f9f9; }
form { margin: 0; }
textarea { width: 100%; min-height: 40px; border-radius: 4px; border: 1px solid #ccc; padding: 6px; }
button { padding: 8px 14px; background: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
button:hover { background: #0056b3; }
a { color: #007bff; text-decoration: none; }
a:hover { text-decoration: underline; }
nav {
    background: linear-gradient(90deg, #223aa5 60%, #00c6ff 100%);
    padding: 12px;
    text-align: center;
}
nav a {
    color: #fff;
    margin: 0 12px;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}
    </style>
</head>
<body>
    <nav>
        <a href="admin.php">Insert Product</a>
        <a href="admin_contacts.php">Answer Questions</a>
        <a href="admin_contacts.php?logout=1">Logout</a>
    </nav>

<h2>Customer Questions</h2>
<p style="text-align: center; color: #666;">
    Logged in as: <strong><?= htmlspecialchars($_SESSION['admin_name']) ?></strong>
    <!-- Debug info -->
    <br><small style="color: #999;">Session ID: <?= session_id() ?> | Session admin_name: <?= isset($_SESSION['admin_name']) ? 'SET' : 'NOT SET' ?></small>
</p>

<?php 
// Show success message
if (isset($_SESSION['success_message'])) {
    echo "<div style='background: #d4edda; color: #155724; padding: 10px; margin: 10px auto; max-width: 98%; border-radius: 4px; text-align: center;'>";
    echo htmlspecialchars($_SESSION['success_message']);
    echo "</div>";
    unset($_SESSION['success_message']);
}

// Show error message
if (isset($update_error)) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 10px; margin: 10px auto; max-width: 98%; border-radius: 4px; text-align: center;'>";
    echo htmlspecialchars($update_error);
    echo "</div>";
}
?>

<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Product</th>
        <th>Question</th>
        <th>Admin Answer</th>
        <th>Admin Name</th>
        <th>Action</th>
    </tr>
    <?php if (empty($results)): ?>
    <tr>
        <td colspan="7" style="text-align: center; padding: 20px; color: #666;">
            No customer questions found. Make sure:
            <ul style="text-align: left; margin: 10px 0;">
                <li>The 'contacts' table exists in your database</li>
                <li>There are records in the contacts table</li>
                <li>Database connection is working properly</li>
            </ul>
        </td>
    </tr>
    <?php else: ?>
        <?php foreach($results as $row): ?>
        <tr>
            <td><?=htmlspecialchars($row['name'] ?? 'N/A')?></td>
            <td><?=htmlspecialchars($row['email'] ?? 'N/A')?></td>
            <td><?=htmlspecialchars($row['product'] ?? 'N/A')?></td>
            <td><?=htmlspecialchars($row['message'] ?? 'N/A')?></td>
            <td><?=htmlspecialchars($row['admin_answer'] ?? '')?></td>
            <td><?=htmlspecialchars($row['admin_name'] ?? '')?></td>
            <td>
                <form method="POST" style="margin:0;">
                    <input type="hidden" name="id" value="<?=$row['id']?>">
                    <textarea name="admin_answer" placeholder="Enter your answer here..." style="width: 100%; min-height: 60px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"><?=htmlspecialchars($row['admin_answer'] ?? '')?></textarea>
                    <input type="text" name="admin_name" value="<?= htmlspecialchars($_SESSION['admin_name']) ?>" readonly style="background-color: #f8f9fa; border: 1px solid #ddd; padding: 4px; margin: 4px 0; width: 100%; box-sizing: border-box;">
                    <button type="submit" style="background: #28a745; padding: 8px 12px; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 5px;">Save Answer</button>
                    
                    <!-- Debug info - remove after testing -->
                    <small style="color: #666; display: block; margin-top: 5px;">
                        ID: <?=$row['id']?> | Current Answer: "<?=htmlspecialchars($row['admin_answer'] ?? 'none')?>"
                    </small>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

</body>
</html>