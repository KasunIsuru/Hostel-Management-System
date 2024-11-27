<?php
session_start();
include '../config/db.php';

if ($_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['user_id'];

// Fetch room details
$stmt = $pdo->prepare("SELECT rooms.* FROM students JOIN rooms ON students.room_number = rooms.room_number WHERE students.id = ?");
$stmt->execute([$student_id]);
$room = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Room Details</title>
</head>
<body>
    <h2>Your Room Details</h2>
    <p><strong>Room Number:</strong> <?= $room['room_number'] ?></p>
    <p><strong>Capacity:</strong> <?= $room['capacity'] ?></p>
    <p><strong>Occupied:</strong> <?= $room['occupied'] ?></p>
    <br><a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
