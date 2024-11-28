<?php
session_start();
include '../config/db.php';

if ($_SESSION['role'] != 'warden') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $nic = $_POST['nic'];
    $phone = $_POST['phone'];
    $university_index = $_POST['university_index'];
    $guardian_name = $_POST['guardian_name'];
    $room_number = $_POST['room_number'];

    try {
        // Check room capacity
        $stmt = $pdo->prepare("SELECT room_id, capacity, occupied FROM rooms WHERE room_number = ?");
        $stmt->execute([$room_number]);
        $room = $stmt->fetch();

        if (!$room) {
            throw new Exception("Room not found.");
        }

        if ($room['occupied'] >= $room['capacity']) {
            throw new Exception("Room is full. Please choose another room.");
        }

        // Start a transaction
        $pdo->beginTransaction();

        // Insert student details
        $stmt = $pdo->prepare("INSERT INTO students (full_name, address, nic, phone, university_index, guardian_name, room_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$full_name, $address, $nic, $phone, $university_index, $guardian_name, $room_number]);

        // Insert student account into `users` table
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'student')");
        $stmt->execute([$university_index, $nic]);
        
        // Update room occupancy
        $stmt = $pdo->prepare("UPDATE rooms SET occupied = occupied + 1 WHERE room_number = ?");
        $stmt->execute([$room_number]);

        $pdo->commit();
        echo "<p style='color: green;'>Student registered successfully!</p>";
    } catch (Exception $e) {
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
<?php include 'header.php'; ?>
    <h2>Register New Student</h2>
    <form method="POST">
        Full Name: <input type="text" name="full_name" required><br>
        Address: <input type="text" name="address" required><br>
        NIC: <input type="text" name="nic" required><br>
        Phone: <input type="text" name="phone" required><br>
        University Index: <input type="text" name="university_index" required><br>
        Guardian Name: <input type="text" name="guardian_name" required><br>
        Room Number: 
        <select name="room_number" required>
            <?php
            $rooms = $pdo->query("SELECT room_number FROM rooms WHERE capacity > occupied")->fetchAll();
            foreach ($rooms as $room) {
                echo "<option value='" . $room['room_number'] . "'>" . $room['room_number'] . "</option>";
            }
            ?>
        </select><br>
        <button type="submit">Register Student</button>
    </form>
    <br><a href="dashboard.php">Back to Dashboard</a>
    <?php include 'footer.php'; ?>
</body>
</html>
