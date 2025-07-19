
<?php
// config/db.php — Function to connect to SQL Server with PDO

function connectWithPDO() {
    $serverName = "192.168.197.137";     // or your SQL Server IP
    $database   = "eccomerce";     // your actual DB name
    $username   = "sa";            // or your SQL Server username
    $password   = "12345";         // your SQL Server password

    try {
        // SQL Server DSN
        $dsn = "sqlsrv:Server=$serverName;Database=$database";

        // Create PDO connection
        $pdo = new PDO($dsn, $username, $password);

        // Set error reporting and fetch mode
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // ✅ Optional success message
        echo "";

        return $pdo;

    } catch (PDOException $e) {
        // ❌ Show clear connection error
        echo "❌ Connection failed: " . $e->getMessage();
        exit;
    }
}
?>
