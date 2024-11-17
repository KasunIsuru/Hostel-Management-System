<?php
include '../config/db.php'; // Adjust the path to your database connection file

$stmt = $pdo->query("SELECT id, password FROM users");
while ($row = $stmt->fetch()) {
    // Hash plain-text password
    $hashed_password = password_hash($row['password'], PASSWORD_DEFAULT);

    // Update database
    $update_stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update_stmt->execute([$hashed_password, $row['id']]);
}

echo "Passwords updated to hashed values!";
?>
