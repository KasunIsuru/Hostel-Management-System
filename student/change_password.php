<?php
session_start();
include '../config/db.php';

// Ensure the logged-in user is a student
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $username = $_SESSION['username']; // Logged-in student's username

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $message = "<p style='color: red;'>All fields are required!</p>";
    } elseif ($new_password !== $confirm_password) {
        $message = "<p style='color: red;'>New password and confirm password do not match!</p>";
    } else {
        try {
            // Fetch the current password for the logged-in user
            $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ? AND role = 'student'");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || $user['password'] !== $current_password) {
                $message = "<p style='color: red;'>Current password is incorrect!</p>";
            } else {
                // Update the password
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ? AND role = 'student'");
                $stmt->execute([$new_password, $username]);
                $message = "<p style='color: green;'>Password updated successfully!</p>";
            }
        } catch (Exception $e) {
            $message = "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    
</head>
<body>
    <h2>Change Password</h2>
    <?= $message ?>
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
        <button type="submit">Change Password</button>
    </form>
    <a class="back-btn" href="dashboard.php">Back to Dashboard</a>
</body>
</html>
