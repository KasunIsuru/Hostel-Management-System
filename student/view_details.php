<?php
$cssPath = "../styles/styles.css";
// Start session and include database configuration
session_start();
include '../config/db.php';

$message = "";
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
        $message = "<p style='color: red;'>No details found for this university index!</p>";
        exit();
    }
} catch (Exception $e) {
    $message = "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    exit();
}
?>

<!-- front end -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Student Details</title>
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

        table td {
            width: 650px;
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
        <h1 class="text-center mb-4">Student Details</h1>

        <?php if ($message): ?>
            <div class="alert alert-success text-center">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">view details</div>
            <div class="card-body">
                <table>
                    <tbody>
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
                    </tbody>
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