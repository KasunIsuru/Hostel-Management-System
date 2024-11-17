<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'warden') {
    header("Location: ../login.php");
    exit();
}

// Fetch all security attendance records
$stmt = $pdo->prepare("SELECT * FROM security_attendance ORDER BY date DESC, id DESC");
$stmt->execute();
$records = $stmt->fetchAll();
?>
<?php include dirname(__DIR__).'/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Security Attendance</title>
</head>
<body>
    <section>
        <h1>Security Attendance Records</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Security ID</th>
                    <th>Date</th>
                    <th>Check-in Time</th>
                    <th>Check-out Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $record): ?>
                    <tr>
                        <td><?= $record['id'] ?></td>
                        <td><?= htmlspecialchars($record['security_id']) ?></td>
                        <td><?= $record['date'] ?></td>
                        <td><?= $record['check_in_time'] ?? 'Not Checked-in' ?></td>
                        <td><?= $record['check_out_time'] ?? 'Not Checked-out' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br><a href="Security_attendance.php">Back</a>
        <br><a href="dashboard.php">Back to Dashboard</a>
    </section>
</body>
</html>

<?php include dirname(__DIR__).'/footer.php'; ?>