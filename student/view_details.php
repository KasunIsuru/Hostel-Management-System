<?php
// Start session and include database configuration
session_start();
include '../config/db.php';

// Ensure the logged-in user is a student
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

// Fetch the logged-in student's username, which corresponds to the university_index
$username = $_SESSION['username']; // University index stored in the session

try {
    // Query to fetch student details based on university_index
    $stmt = $pdo->prepare("SELECT * FROM students WHERE university_index = ?");
    $stmt->execute([$username]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        echo "<p style='color: red;'>No details found for this university index!</p>";
        exit();
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Student Details</title>
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
        <h2>Student Details</h2>
        <table>
            <tr>
                <th>Full Name</th>
                <td><?php echo htmlspecialchars($student['full_name']); ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?php echo htmlspecialchars($student['address']); ?></td>
            </tr>
            <tr>
                <th>NIC</th>
                <td><?php echo htmlspecialchars($student['nic']); ?></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><?php echo htmlspecialchars($student['phone']); ?></td>
            </tr>
            <tr>
                <th>University Index</th>
                <td><?php echo htmlspecialchars($student['university_index']); ?></td>
            </tr>
            <tr>
                <th>Guardian Name</th>
                <td><?php echo htmlspecialchars($student['guardian_name']); ?></td>
            </tr>
            <tr>
                <th>Room Number</th>
                <td><?php echo htmlspecialchars($student['room_number']); ?></td>
            </tr>
        </table>
        <a class="back-btn" href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
