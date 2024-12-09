<?php
// Start session and include database configuration
$cssPath = "../styles/styles.css";
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

<!-- front end -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Submit Late Attendance Request</title>
    <link rel="stylesheet" href="<?php echo $cssPath; ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: auto;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }



        form {
            display: flex;
            flex-direction: column;
        }

        label,
        textarea,
        button {
            margin-bottom: 15px;
        }

        textarea,
        button {
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

        .card-header {
            color: #660097;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1 class="text-center mb-4">Submit Late Attendance Request</h1>

        <?php if (isset($success_message)): ?>
            <p class="alert alert-success text-center"><?php echo $success_message; ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="alert alert-danger"><?php echo $error_message; ?></p>
        <?php endif; ?>


        <div class="card mb-4">
            <div class="card-header">Reason</div>
            <div class="card-body">
                <form method="POST">
                    <textarea id="reason" name="reason" rows="4" required></textarea>
                    <button type="submit">Submit Request</button>
                </form>

            </div>
        </div>

        <div class="text-center">
            <a href="dashboard.php" class="btn btn-danger">Back to Dashboard</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>