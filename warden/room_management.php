<?php
session_start();
include '../config/db.php';

if ($_SESSION['role'] != 'warden') {
    header("Location: ../login.php");
    exit();
}

// Fetch room details (for simplicity, assumed that there’s a 'rooms' table)
$stmt = $pdo->query("SELECT * FROM rooms ORDER BY room_number");
$rooms = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Management</title>
</head>
<body>
    <h2>Manage Rooms</h2>
    <table border="1">
        <tr>
            <th>Room Number</th>
            <th>Capacity</th>
            <th>Occupied</th>
        </tr>
        <?php foreach ($rooms as $room): ?>
        <tr>
            <td><?= $room['room_number'] ?></td>
            <td><?= $room['capacity'] ?></td>
            <td><?= $room['occupied'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br><a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
