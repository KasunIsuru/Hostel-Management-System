<?php
session_start();
include '../config/db.php';

echo "<h2>Password Verification Debug Information</h2>";

// 1. Check Session Data
echo "<h3>1. Session Information:</h3>";
echo "Session Username: " . ($_SESSION['username'] ?? 'Not set') . "<br>";
echo "Session Role: " . ($_SESSION['role'] ?? 'Not set') . "<br><br>";

// 2. Database Connection Test
echo "<h3>2. Database Connection Test:</h3>";
try {
    $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS);
    echo "Database connection: SUCCESS<br><br>";
} catch(PDOException $e) {
    echo "Database connection: FAILED<br>";
    echo "Error: " . $e->getMessage() . "<br><br>";
}

// 3. User Query Test
echo "<h3>3. User Query Test:</h3>";
if(isset($_SESSION['username'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$_SESSION['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($user) {
            echo "User found in database: YES<br>";
            echo "Username: " . htmlspecialchars($user['username']) . "<br>";
            echo "Stored Password Hash Length: " . strlen($user['password']) . "<br>";
            echo "Stored Password Hash: " . htmlspecialchars($user['password']) . "<br>";
            echo "User Role: " . htmlspecialchars($user['role']) . "<br><br>";
        } else {
            echo "User found in database: NO<br><br>";
        }
    } catch(PDOException $e) {
        echo "User query failed: " . $e->getMessage() . "<br><br>";
    }
}

// 4. Password Hash Test
if(isset($_POST['test_password'])) {
    echo "<h3>4. Password Verification Test:</h3>";
    $test_password = $_POST['test_password'];
    
    if($user) {
        echo "Testing password: " . str_repeat('*', strlen($test_password)) . "<br>";
        echo "Password verification result: " . (password_verify($test_password, $user['password']) ? 'SUCCESS' : 'FAILED') . "<br>";
        
        // Show what a new hash would look like
        echo "New hash for entered password: " . password_hash($test_password, PASSWORD_DEFAULT) . "<br>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Debug</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .debug-form { margin: 20px 0; padding: 20px; background: #f5f5f5; }
        input[type="password"] { padding: 5px; margin: 5px 0; }
        button { padding: 5px 10px; }
    </style>
</head>
<body>
    <div class="debug-form">
        <h3>Test Password Verification</h3>
        <form method="POST">
            <input type="password" name="test_password" placeholder="Enter password to test" required>
            <button type="submit">Test Password</button>
        </form>
    </div>
    
    <div>
        <h3>SQL Query to Check User Table:</h3>
        <code>
            SELECT * FROM users WHERE username = '[your_username]';
        </code>
    </div>
</body>
</html>