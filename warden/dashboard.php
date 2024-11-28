<?php

session_start();
if ($_SESSION['role'] != 'warden') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Warden Dashboard</title>
</head>

<body>
    <?php include 'header.php'; ?>

    <h1>Welcome, Warden</h1>
    <a href="register_student.php">Register Student</a><br>
    <a href="view_students.php">View/Search Students</a><br>
    <a href="room_management.php">Manage Rooms</a><br>
    <a href="view_late_requests.php">View Late Attendance Requests</a><br>
    <a href="security_attendance.php">Mark Security Attendance</a><br>
    <a href="../logout.php">Logout</a>

    <?php include 'footer.php'; ?>
</body>

</html>