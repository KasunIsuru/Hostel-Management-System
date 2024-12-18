<?php
session_start();
$cssPath = "../styles/styles.css";
include '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'warden') {
    header("Location: ../login.php");
    exit();
}

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $security_id = $_POST['security_id'] ?? null;
    $date = $_POST['date'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($security_id && $date && $action) {
        if ($action == 'Check-in') {
            // Insert a new check-in record
            $stmt = $pdo->prepare("INSERT INTO security_attendance (security_id, date, check_in_time) VALUES (?, ?, NOW())");
            $stmt->execute([$security_id, $date]);
            $message = "Check-in recorded successfully!";
        } elseif ($action == 'Check-out') {
            // Update the check-out time for an existing record
            $stmt = $pdo->prepare("UPDATE security_attendance SET check_out_time = NOW() WHERE security_id = ? AND date = ? AND check_out_time IS NULL");
            $stmt->execute([$security_id, $date]);

            if ($stmt->rowCount() > 0) {
                $message = "Check-out recorded successfully!";
            } else {
                $message = "Check-out failed. No matching check-in found for this date.";
            }
        } else {
            $message = "Invalid action selected.";
        }
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!-- front end -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Security Attendance</title>
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
        <h1 class="text-center mb-4">Security Attendance</h1>

        <?php if ($message): ?>
            <div class="alert alert-success text-center">
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
                                <th><label for="security_id">Security ID</label></th>
                                <th><label for="date">Date</label></th>
                                <th><label for="action">Action</label></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" id="security_id" class="form-control mr-2" name="security_id" required></td>
                                <td><input type="date" id="date" class="form-control mr-2" name="date" required></td>
                                <td><select id="action" class="form-control mr-2" name="action" required>
                                        <option value="Check-in">Check-in</option>
                                        <option value="Check-out">Check-out</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"><button type="submit" class="btn btn-primary">Submit</button></td>
                            </tr>
                        </tbody>
                    </form>
                </table>

            </div>
        </div>

        <div class="text-center">
            <a href="view_security_attendance.php" class="btn btn-primary mb-4">View All Security Attendance</a>
        </div>
        <div class="text-center">
            <a href="dashboard.php" class="btn btn-danger">Back to Dashboard</a>
        </div>

    </div>
    <?php include 'footer.php'; ?>
</body>

</html>