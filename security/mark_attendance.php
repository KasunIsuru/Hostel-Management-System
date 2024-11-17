<?php
session_start();
include '../config/db.php';

// Check if the user is logged in as security
if ($_SESSION['role'] != 'security') {
    header("Location: ../login.php");
    exit();
}

// Initialize message
$message = "";

// Process form submission for marking attendance
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $university_index = $_POST['university_index'];
    $action = $_POST['action'];

    // Fetch the student record based on the university index
    $stmt = $pdo->prepare("SELECT * FROM students WHERE university_index = ?");
    $stmt->execute([$university_index]);
    $student = $stmt->fetch();

    if ($student) {
        $student_id = $student['university_index'];

        // Determine action (Check-In or Check-Out)
        if ($action === 'Check-In') {
            // Ensure no previous open Check-In exists
            $stmt = $pdo->prepare("SELECT * FROM attendance WHERE student_id = ? AND check_out_time IS NULL");
            $stmt->execute([$student_id]);
            $open_check_in = $stmt->fetch();

            if ($open_check_in) {
                $message = "Error: Student already checked in. Please check out first.";
            } else {
                // Insert new Check-In record
                $stmt = $pdo->prepare("INSERT INTO attendance (student_id, check_in_time) VALUES (?, NOW())");
                $stmt->execute([$student_id]);
                $message = "Check-In recorded successfully!";
            }
        } elseif ($action === 'Check-Out') {
            // Update the Check-Out time for the latest Check-In
            $stmt = $pdo->prepare("UPDATE attendance SET check_out_time = NOW() WHERE student_id = ? AND check_out_time IS NULL");
            $stmt->execute([$student_id]);

            if ($stmt->rowCount() > 0) {
                $message = "Check-Out recorded successfully!";
            } else {
                $message = "Error: No open Check-In found for this student.";
            }
        }
    } else {
        $message = "Error: Student not found!";
    }
}

// Fetch students for the search dropdown
$search = $_GET['search'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM students WHERE full_name LIKE ? OR university_index LIKE ?");
$stmt->execute(["%$search%", "%$search%"]);
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Student Attendance</title>
</head>
<body>
    <h1>Mark Student Attendance</h1>

    <?php if (!empty($message)) : ?>
        <p style="color: <?= strpos($message, 'Error') === false ? 'green' : 'red' ?>;">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <label for="university_index">Search Student:</label>
        <select name="university_index" required>
            <option value="">Select a Student</option>
            <?php foreach ($students as $student): ?>
                <option value="<?= htmlspecialchars($student['university_index']) ?>">
                    <?= htmlspecialchars($student['full_name']) ?> (<?= htmlspecialchars($student['university_index']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="action">Action:</label>
        <select name="action" required>
            <option value="Check-In">Check-In</option>
            <option value="Check-Out">Check-Out</option>
        </select>
        <br><br>

        <button type="submit">Submit</button>
    </form>

    <br><a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
