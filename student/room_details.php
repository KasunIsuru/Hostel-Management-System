<?php
session_start();
include '../config/db.php';

// Ensure the logged-in user is a student
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

// Fetch the logged-in student's university index
$username = $_SESSION['username']; // University index stored in the session

try {
    // Query to get the student's room details
    $stmt = $pdo->prepare("
        SELECT r.room_id, r.room_number 
        FROM students s
        INNER JOIN rooms r ON s.room_number = r.room_number
        WHERE s.university_index = ?
    ");
    $stmt->execute([$username]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$room) {
        echo "<p style='color: red;'>Room details not found for this student.</p>";
        exit();
    }

    $room_id = $room['room_id'];
    $room_number = $room['room_number'];

    // Query to get furniture details for the room
    $stmt = $pdo->prepare("
        SELECT furniture_type, furniture_id 
        FROM room_furniture
        WHERE room_id = ?
    ");
    $stmt->execute([$room_id]);
    $furniture_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Room Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .container {
            text-align: center;
        }
        .back-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Room Details</h2>
        <table>
            <tr>
                <th>Room Number</th>
                <td><?php echo htmlspecialchars($room_number); ?></td>
            </tr>
        </table>

        <?php if (!empty($furniture_details)): ?>
            <h3>Furniture Details</h3>
            <table>
                <tr>
                    <th>Furniture Type</th>
                    <th>Furniture ID</th>
                </tr>
                <?php foreach ($furniture_details as $furniture): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($furniture['furniture_type']); ?></td>
                        <td><?php echo htmlspecialchars($furniture['furniture_id']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No furniture details available for this room.</p>
        <?php endif; ?>

        <a class="back-btn" href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
