<?php
session_start();
if ($_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
</head>
<body>
    <h1>Welcome, Student</h1>
    <a href="view_details.php">View Your Details</a><br>
    <a href="room_details.php">View Room Details</a><br>
    <a href="late_request.php">Submit Late Attendance Request</a><br>
    <a href="change_password.php">Change Password</a><br>
    <a href="student_view_late_requests.php">View Late Attendance Request</a><br>
    <a href="../logout.php">Logout</a>
</body>
</html>
