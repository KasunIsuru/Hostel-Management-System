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
        <h1 class="text-center mb-4">Room Management</h1>

        <?php if ($message): ?>
            <div class="alert alert-success text-center">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Create Room -->
        <div class="card mb-4">
            <div class="card-header">Create Room</div>
            <div class="card-body">
                <form method="POST" class="form-inline">
                    <input type="text" name="room_number" class="form-control mr-2" placeholder="Room Number" required>
                    <button type="submit" name="create_room" class="btn btn-primary">Create Room</button>
                </form>
            </div>
        </div>

        <!-- Add Furniture -->
        <div class="card mb-4">
            <div class="card-header">Add Furniture</div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="room_id">Room</label>
                        <select id="room_id" name="room_id" class="form-control" required>
                            <?php foreach ($rooms as $room): ?>
                                <option value="<?= $room['room_id'] ?>"><?= $room['room_number'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="furniture_type">Furniture Type</label>
                        <select id="furniture_type" name="furniture_type" class="form-control" required>
                            <option value="Table">Table</option>
                            <option value="Chair">Chair</option>
                            <option value="Rack">Rack</option>
                            <option value="Cupboard">Cupboard</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="furniture_id">Furniture ID</label>
                        <input type="text" id="furniture_id" name="furniture_id" class="form-control" required>
                    </div>
                    <button type="submit" name="add_furniture" class="btn btn-primary">Add Furniture</button>
                </form>
            </div>
        </div>

        <!-- View Room Furniture -->
        <div class="card mb-4">
            <div class="card-header">View Room Furniture</div>
            <div class="card-body">
                <form method="GET" class="form-inline">
                    <input type="text" name="search_room" class="form-control mr-2" placeholder="Room Number" value="<?= $_GET['search_room'] ?? '' ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                <?php if (!empty($furniture_details)): ?>
                    <h5 class="mt-3">Furniture Details:</h5>
                    <table>
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
            </div>
        </div>

        <!-- Room List -->
        <div class="card mb-4">
            <div class="card-header">Room List</div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>Room Number</th>
                            <th>Capacity</th>
                            <th>Occupied</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rooms as $room): ?>
                            <tr>
                                <td><?= htmlspecialchars($room['room_number']) ?></td>
                                <td><?= htmlspecialchars($room['capacity']) ?></td>
                                <td><?= htmlspecialchars($room['occupied']) ?></td>
                            </tr>
                        <?php endforeach; ?>
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