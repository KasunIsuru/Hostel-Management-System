<?php
session_start();
$cssPath = "../styles/styles.css";
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

<!-- front end -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Security Attendance</title>
    <link rel="stylesheet" href="<?php echo $cssPath; ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <style>
        .container {
            max-width: auto;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .message {
            color: green;
        }

        .card-header {
            color: #660097;
            font-weight: bold;

        }
    </style>


</head>

<body>
    <?php include 'header.php'; ?>
    <section>
        <h1>Security Attendance Records</h1>
        <table>
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
        <button><a href="Security_attendance.php">Back</a></button>
        <br><a href="dashboard.php">Back to Dashboard</a>
    </section>
    <?php include 'footer.php'; ?>
</body>

</html>