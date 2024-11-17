<?php
session_start();
if ($_SESSION['role'] != 'security') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Security Dashboard</title>
</head>
<body>
    <h1>Welcome, Security</h1>
    <a href="mark_attendance.php">Mark Student Attendance</a><br>
    <a href="../logout.php">Logout</a>
</body>
</html>
