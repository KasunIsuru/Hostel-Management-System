<?php
session_start();
$cssPath = "../styles/styles.css";
include '../config/db.php';

// Verify if the user is logged in and is a warden
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'warden') {
    header("Location: ../index.php");
    exit();
}

// Handle the status update of a late request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE late_requests SET status = ? WHERE id = ?");
    $stmt->execute([$status, $request_id]);

    $message = "Request status updated successfully!";
}

// Fetch all late requests with student details
$query = "
    SELECT lr.id, s.university_index AS student_username, lr.request_time, lr.reason, lr.status
    FROM late_requests lr
    JOIN students s ON lr.student_id = s.id
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$late_requests = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>View Late Attendance Requests</title>
    <link rel="stylesheet" href="<?php echo $cssPath; ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <style>
        a {
            display: block;
            text-align: center;
            margin: 20px auto;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <h1>View Late Attendance Requests</h1>
    <?php if (isset($message)) {
        echo "<p style='color: green; text-align: center;'>$message</p>";
    } ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Username</th>
                <th>Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($late_requests) > 0): ?>
                <?php foreach ($late_requests as $request): ?>
                    <tr>
                        <td><?php echo $request['id']; ?></td>
                        <td><?php echo htmlspecialchars($request['student_username']); ?></td>
                        <td><?php echo $request['request_time']; ?></td>
                        <td><?php echo htmlspecialchars($request['reason']); ?></td>
                        <td><?php echo htmlspecialchars($request['status']); ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                                <select class="form-select" name="status">
                                    <option value="Pending" <?php if ($request['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="Approved" <?php if ($request['status'] == 'Approved') echo 'selected'; ?>>Approved</option>
                                    <option value="Rejected" <?php if ($request['status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                                </select>
                                <button class="btn btn-primary" type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No late attendance requests found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <a class="btn btn-danger" href="dashboard.php">Back to Dashboard</a>
    </div>


    <?php include 'footer.php'; ?>
</body>

</html>