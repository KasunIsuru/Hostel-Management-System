<?php
session_start();
include '../config/db.php';

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

    echo "Student details updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Student</title>
</head>
<body>
    <h2>Update Student Details</h2>
    <form method="POST">
        Full Name: <input type="text" name="full_name" value="<?= $student['full_name'] ?>" required><br>
        Address: <input type="text" name="address" value="<?= $student['address'] ?>" required><br>
        NIC: <input type="text" name="nic" value="<?= $student['nic'] ?>" required><br>
        Phone: <input type="text" name="phone" value="<?= $student['phone'] ?>" required><br>
        University Index: <input type="text" name="university_index" value="<?= $student['university_index'] ?>" required><br>
        Guardian Name: <input type="text" name="guardian_name" value="<?= $student['guardian_name'] ?>" required><br>
        Room Number: <input type="text" name="room_number" value="<?= $student['room_number'] ?>" required><br>
        <button type="submit">Update Student</button>
    </form>
    <br><a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
