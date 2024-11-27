<?php
session_start();
include '../config/db.php';

if ($_SESSION['role'] != 'warden') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $nic = $_POST['nic'];
    $phone = $_POST['phone'];
    $university_index = $_POST['university_index'];
    $guardian_name = $_POST['guardian_name'];
    $room_number = $_POST['room_number'];

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Insert student details into `students` table
        $stmt = $pdo->prepare("INSERT INTO students (full_name, address, nic, phone, university_index, guardian_name, room_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$full_name, $address, $nic, $phone, $university_index, $guardian_name, $room_number]);

        // Insert student account into `users` table
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'student')");
        $stmt->execute([$university_index, $nic]);

        // Commit the transaction
        $pdo->commit();

        echo "<p style='color: green;'>Student registered and user account created successfully!</p>";
    } catch (Exception $e) {
        // Rollback in case of error
        $pdo->rollBack();
        echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Student</title>
</head>
<body>
    <h2>Register New Student</h2>
    <form method="POST">
        Full Name: <input type="text" name="full_name" required><br>
        Address: <input type="text" name="address" required><br>
        NIC: <input type="text" name="nic" required><br>
        Phone: <input type="text" name="phone" required><br>
        University Index: <input type="text" name="university_index" required><br>
        Guardian Name: <input type="text" name="guardian_name" required><br>
        Room Number: <input type="text" name="room_number" required><br>
        <button type="submit">Register Student</button>
    </form>
    <br><a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
