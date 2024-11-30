<?php
session_start();
$cssPath = "../styles/styles.css";
include '../config/db.php';


if ($_SESSION['role'] != 'warden') {
    header("Location: ../login.php");
    exit();
}

$message = "";
$furniture_details = [];

// Handle room creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_room'])) {
    $room_number = $_POST['room_number'];

    try {
        $stmt = $pdo->prepare("INSERT INTO rooms (room_number) VALUES (?)");
        $stmt->execute([$room_number]);
        $message = "Room created successfully!";
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Handle furniture addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_furniture'])) {
    $room_id = $_POST['room_id'];
    $furniture_type = $_POST['furniture_type'];
    $furniture_id = $_POST['furniture_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO room_furniture (room_id, furniture_type, furniture_id) VALUES (?, ?, ?)");
        $stmt->execute([$room_id, $furniture_type, $furniture_id]);
        $message = "Furniture added successfully!";
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Handle furniture search
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search_room'])) {
    $search_room = $_GET['search_room'];

    $stmt = $pdo->prepare("
        SELECT rf.furniture_type, rf.furniture_id 
        FROM room_furniture rf
        INNER JOIN rooms r ON rf.room_id = r.room_id
        WHERE r.room_number = ?
    ");
    $stmt->execute([$search_room]);
    $furniture_details = $stmt->fetchAll();

    if (empty($furniture_details)) {
        $message = "No furniture found for room number $search_room.";
    }
}

// Fetch rooms
$stmt = $pdo->query("SELECT * FROM rooms ORDER BY room_number");
$rooms = $stmt->fetchAll();
?>


<!-- front end -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Room Management</title>
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
    <h1 class="text-center mt-4">Room Management</h1>
    <?php if ($message): ?>
        <p style="color: green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <h3>Create Room</h3>
    <form method="POST">
        <label for="room_number">Room Number:</label>
        <input type="text" id="room_number" name="room_number" required>
        <button type="submit" name="create_room">Create Room</button>
    </form>

    <h3>Add Furniture</h3>
    <form method="POST">
        <label for="room_id">Room ID:</label>
        <select id="room_id" name="room_id" required>
            <?php foreach ($rooms as $room): ?>
                <option value="<?= $room['room_id'] ?>"><?= $room['room_number'] ?></option>
            <?php endforeach; ?>
        </select><br>
        <label for="furniture_type">Furniture Type:</label>
        <select id="furniture_type" name="furniture_type" required>
            <option value="Table">Table</option>
            <option value="Chair">Chair</option>
            <option value="Rack">Rack</option>
            <option value="Cupboard">Cupboard</option>
        </select><br>
        <label for="furniture_id">Furniture ID:</label>
        <input type="text" id="furniture_id" name="furniture_id" required>
        <button type="submit" name="add_furniture">Add Furniture</button>
    </form>

    <h3>View Room Furniture</h3>
    <form method="GET">
        <label for="search_room">Room Number:</label>
        <input type="text" id="search_room" name="search_room" value="<?= $_GET['search_room'] ?? '' ?>">
        <button type="submit">Search</button>
    </form>

    <?php if (!empty($furniture_details)): ?>
        <h4>Furniture Details for Room <?= htmlspecialchars($_GET['search_room']) ?>:</h4>
        <table border="1">
            <tr>
                <th>Furniture Type</th>
                <th>Furniture ID</th>
            </tr>
            <?php foreach ($furniture_details as $furniture): ?>
                <tr>
                    <td><?= htmlspecialchars($furniture['furniture_type']) ?></td>
                    <td><?= htmlspecialchars($furniture['furniture_id']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <!-- room list table -->
    <h3 class="text-center mt-4">Room List</h3>
    <table>
        <thead>
            <tr>
                <th>Room Number</th>
                <th>Capacity</th>
                <th>Occupied</th>
            </tr>
        </thead>

        <?php foreach ($rooms as $room): ?>
            <tr>
                <td><?= htmlspecialchars($room['room_number']) ?></td>
                <td><?= htmlspecialchars($room['capacity']) ?></td>
                <td><?= htmlspecialchars($room['occupied']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="d-flex justify=content-center">
        <a class="btn btn-danger" href="dashboard.php">Back to Dashboard</a>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>