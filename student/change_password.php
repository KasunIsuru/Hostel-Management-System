<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    try {
        // Fetch current user's hashed password
        $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->execute([$_SESSION['username']]);
        $user = $stmt->fetch();

        if ($user) {
            // Verify the current password
            if (!password_verify($current_password, $user['password'])) {
                $message = "Current password is incorrect!";
                $messageType = 'error';
            } elseif ($new_password !== $confirm_password) {
                $message = "New passwords do not match!";
                $messageType = 'error';
            } elseif (strlen($new_password) < 4) {
                $message = "New password must be at least 4 characters long!";
                $messageType = 'error';
            } else {
                // Hash the new password
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
                if ($update_stmt->execute([$new_hashed_password, $_SESSION['username']])) {
                    $message = "Password changed successfully!";
                    $messageType = 'success';
                } else {
                    $message = "Failed to update password. Please try again.";
                    $messageType = 'error';
                }
            }
        } else {
            $message = "User not found!";
            $messageType = 'error';
        }
    } catch (PDOException $e) {
        $message = "Database error occurred. Please try again.";
        $messageType = 'error';
        error_log("Password change error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <style>
        /* Your CSS styling */
    </style>
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>

        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>

            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn">Change Password</button>
        </form>
    </div>
</body>
</html>
