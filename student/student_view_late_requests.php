<?php
session_start();
include '../config/db.php';

// Verify if the user is logged in and is a student
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
    header("Location: ../index.php");
    exit();
}

// Fetch the logged-in student's ID
$student_username = $_SESSION['username'];

// Query to fetch student details
$stmt = $pdo->prepare("SELECT id FROM students WHERE university_index = ?");
$stmt->execute([$student_username]);
$student = $stmt->fetch();

if (!$student) {
    echo "Student record not found!";
    exit();
}

$student_id = $student['id'];

// Fetch the late requests for this student
$query = "SELECT request_time, reason, status FROM late_requests WHERE student_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$student_id]);
$late_requests = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Late Attendance Requests</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        h1 {
            text-align: center;
        }
        a {
            display: block;
            text-align: center;
            margin: 20px auto;
            color: blue;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>My Late Attendance Requests</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($late_requests) > 0): ?>
                <?php foreach ($late_requests as $request): ?>
                    <tr>
                        <td><?php echo $request['request_time']; ?></td>
                        <td><?php echo htmlspecialchars($request['reason']); ?></td>
                        <td><?php echo htmlspecialchars($request['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No late attendance requests found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
