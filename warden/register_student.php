<?php
session_start();
$cssPath = "../styles/styles.css";
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
        $message = "Student registered successfully!";
        // echo "<p style='color: green;'>Student registered successfully!</p>";
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Error: " . $e->getMessage();
        // echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!-- front end -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Student</title>
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
        <h1 class="text-center mb-4">Register New Student</h1>

        <?php if ($message): ?>
            <div class="alert alert-success text-center">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">Register</div>
            <div class="card-body">

                <table>
                    <form method="POST">
                        <tbody>
                            <tr>
                                <th>Full Name</th>
                                <td><input type="text" class="form-control mr-2" name="full_name" required></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><input type="text" class="form-control mr-2" name="address" required></td>
                            </tr>
                            <tr>
                                <th>NIC</th>
                                <td><input type="text" class="form-control mr-2" name="nic" required></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><input type="text" class="form-control mr-2" name="phone" required></td>
                            </tr>
                            <tr>
                                <th>University Index</th>
                                <td><input type="text" class="form-control mr-2" name="university_index" required></td>
                            </tr>
                            <tr>
                                <th>Guardian Name</th>
                                <td><input type="text" class="form-control mr-2" name="guardian_name" required></td>
                            </tr>
                            <tr>
                                <th>Room Number</th>
                                <td>
                                    <select class="form-control mr-2" name="room_number" required>
                                        <?php
                                        $rooms = $pdo->query("SELECT room_number FROM rooms WHERE capacity > occupied")->fetchAll();
                                        foreach ($rooms as $room) {
                                            echo "<option value='" . $room['room_number'] . "'>" . $room['room_number'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><button type="submit" class="btn btn-primary">Register Student</button></td>
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