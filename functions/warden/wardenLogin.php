<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verify user credentials
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on user role
        if ($user['role'] == 'student') {
            header("Location: student/dashboard.php");
        } elseif ($user['role'] == 'warden') {
            header("Location: warden/dashboard.php");
        } elseif ($user['role'] == 'security') {
            header("Location: security/dashboard.php");
        }
        exit();
    } else {
        echo "<p style='color: red;'>Invalid username or password!</p>";
    }
}
?>
