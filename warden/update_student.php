<?php
session_start();
$cssPath = "../styles/styles.css";
include '../config/db.php';
$message = "";

if ($_SESSION['role'] != 'warden') {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Student ID is missing!";
    exit();
}

$student_id = $_GET['id'];

// Fetch student details
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $nic = $_POST['nic'];
    $phone = $_POST['phone'];
    $university_index = $_POST['university_index'];
    $guardian_name = $_POST['guardian_name'];
    $room_number = $_POST['room_number'];

    $stmt = $pdo->prepare("UPDATE students SET full_name = ?, address = ?, nic = ?, phone = ?, university_index = ?, guardian_name = ?, room_number = ? WHERE id = ?");
    $stmt->execute([$full_name, $address, $nic, $phone, $university_index, $guardian_name, $room_number, $student_id]);

    $message = "Student details updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Student</title>
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
        <h1 class="text-center mb-4">Update Student Details</h1>

        <?php if ($message): ?>
            <div class="alert alert-success text-center">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">Student details</div>
            <div class="card-body">

                <table>
                    <form method="POST">
                        <tbody>
                            <tr>
                                <th>Full Name</th>
                                <td><input type="text" class="form-control mr-2" name="full_name" value="<?= $student['full_name'] ?>" required></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><input type="text" class="form-control mr-2" name="address" value="<?= $student['address'] ?>" required></td>
                            </tr>
                            <tr>
                                <th>NIC</th>
                                <td><input type="text" class="form-control mr-2" name="nic" value="<?= $student['nic'] ?>" required></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><input type="text" class="form-control mr-2" name="phone" value="<?= $student['phone'] ?>" required></td>
                            </tr>
                            <tr>
                                <th>University Index</th>
                                <td><input type="text" class="form-control mr-2" name="university_index" value="<?= $student['university_index'] ?>" required></td>
                            </tr>
                            <tr>
                                <th>Guardian Name</th>
                                <td><input type="text" class="form-control mr-2" name="guardian_name" value="<?= $student['guardian_name'] ?>" required></td>
                            </tr>
                            <tr>
                                <th>Room Number</th>
                                <td><input type="text" class="form-control mr-2" name="room_number" value="<?= $student['room_number'] ?>" required></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="submit" class="btn btn-primary">Update Student</button>
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