<?php

session_start();
$cssPath = "../styles/styles.css";
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

<!-- front end -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mark Student Attendance</title>
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

    <div class="container">
        <h1 class="text-center mb-4">Mark Student Attendance</h1>

        <?php if (!empty($message)) : ?>
            <div class="alert alert-success text-center" style="color: <?= strpos($message, 'Error') === false ? 'green' : 'red' ?>;">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>


        <div class="card mb-4">
            <div class="card-header">Security Attendace</div>
            <div class="card-body">
                <table>
                    <form method="POST">
                        <thead>
                            <tr>
                                <th>Search Student</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select class="form-control mr-2" name="university_index" required>
                                        <option value="">Select a Student</option>
                                        <?php foreach ($students as $student): ?>
                                            <option value="<?= htmlspecialchars($student['university_index']) ?>">
                                                <?= htmlspecialchars($student['full_name']) ?> (<?= htmlspecialchars($student['university_index']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control mr-2" name="action" required>
                                        <option value="Check-In">Check-In</option>
                                        <option value="Check-Out">Check-Out</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </td>
                            </tr>
                        </tbody>
                    </form>
                </table>
            </div>
        </div>

        <div class="text-center">
            <a href="dashboard.php" class="btn btn-danger">Back to Dashboard</a>
        </div>

    </div>
    <?php include 'footer.php'; ?>
</body>

</html>