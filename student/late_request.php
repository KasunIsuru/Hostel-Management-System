<?php
// Start session and include database configuration
session_start();
include '../config/db.php';

// Ensure the user is logged in and has the 'student' role
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

// Get the student ID based on the logged-in username (university_index)
$username = $_SESSION['username']; // university_index from session
$stmt = $pdo->prepare("SELECT id FROM students WHERE university_index = ?");
$stmt->execute([$username]);
$student = $stmt->fetch();

if (!$student) {
    die("Student record not found!");
}

$student_id = $student['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reason = $_POST['reason'];

    try {
        // Insert the late request into the database
        $stmt = $pdo->prepare("INSERT INTO late_requests (student_id, reason) VALUES (?, ?)");
        $stmt->execute([$student_id, $reason]);
        $success_message = "Late attendance request submitted successfully!";
    } catch (Exception $e) {
        $error_message = "Error submitting request: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Late Attendance Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label, textarea, button {
            margin-bottom: 15px;
        }
        textarea, button {
            padding: 10px;
            font-size: 14px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            margin-top: 10px;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Submit Late Attendance Request</h2>
        <?php if (isset($success_message)): ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="reason">Reason:</label>
            <textarea id="reason" name="reason" rows="4" required></textarea>
            <button type="submit">Submit Request</button>
        </form>
        <br>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
