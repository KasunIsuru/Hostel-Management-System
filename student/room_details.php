<?php
$cssPath = "../styles/styles.css";
session_start();
include '../config/db.php';

$message = "";
// Ensure the logged-in user is a student
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

// Fetch the logged-in student's university index
$username = $_SESSION['username']; // University index stored in the session

try {
    // Query to get the student's room details
    $stmt = $pdo->prepare("
        SELECT r.room_id, r.room_number 
        FROM students s
        INNER JOIN rooms r ON s.room_number = r.room_number
        WHERE s.university_index = ?
    ");
    $stmt->execute([$username]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$room) {
        echo "<p style='color: red;'>Room details not found for this student.</p>";
        exit();
    }

    $room_id = $room['room_id'];
    $room_number = $room['room_number'];

    // Query to get furniture details for the room
    $stmt = $pdo->prepare("
        SELECT furniture_type, furniture_id 
        FROM room_furniture
        WHERE room_id = ?
    ");
    $stmt->execute([$room_id]);
    $furniture_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>View Room Details</title>
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
        <h1 class="text-center mb-4">Room Details</h1>

        <?php if ($message): ?>
            <div class="alert alert-success text-center">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">Room details</div>
            <div class="card-body">
                <table>
                    <tbody>
                        <tr>
                            <th>Room Number</th>
                            <td><?php echo htmlspecialchars($room_number); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>



        <?php if (!empty($furniture_details)): ?>
            <div class="card mb-4">
                <div class="card-header">Furniture Details</div>
                <div class="card-body">
                    <table>
                        <tr>
                            <th>Furniture Type</th>
                            <th>Furniture ID</th>
                        </tr>
                        <?php foreach ($furniture_details as $furniture): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($furniture['furniture_type']); ?></td>
                                <td><?php echo htmlspecialchars($furniture['furniture_id']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>

        <?php else: ?>
            <div class="alert alert-success text-center">
                <span>No furniture details available for this room</span>
            </div>
        <?php endif; ?>

        <div class="text-center">
            <a href="dashboard.php" class="btn btn-danger">Back to Dashboard</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>