<?php
session_start();
include '../config/db.php';

if ($_SESSION['role'] != 'warden') {
    header("Location: ../login.php");
    exit();
}

$search = $_GET['search'] ?? '';

// Query to fetch students and their latest attendance status
$query = "
    SELECT students.*, 
           CASE 
               WHEN attendance.check_out_time IS NULL AND attendance.check_in_time IS NOT NULL THEN 'In'
               WHEN attendance.check_out_time IS NOT NULL THEN 'Out'
               ELSE 'No Status'
           END AS status 
    FROM students
    LEFT JOIN attendance 
        ON students.university_index = attendance.student_id 
        AND attendance.check_in_time = (
            SELECT MAX(a.check_in_time)
            FROM attendance a
            WHERE a.student_id = students.university_index
        )
    WHERE full_name LIKE ? OR university_index LIKE ?
    GROUP BY students.university_index";
$stmt = $pdo->prepare($query);
$stmt->execute(["%$search%", "%$search%"]);
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Students</title>
    <link rel="stylesheet" href="<?php echo $cssPath; ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>


<body>
    <?php include 'header.php'; ?>

    <h2>View/Search Students</h2>
    <form method="GET">
        <input type="text" name="search" placeholder="Enter name or university index" value="<?= $search ?>">
        <button type="submit">Search</button>
    </form>
    <table border="1">
        <tr>
            <th>Full Name</th>
            <th>University Index</th>
            <th>Room Number</th>
            <th>Student Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['full_name']) ?></td>
                <td><?= htmlspecialchars($student['university_index']) ?></td>
                <td><?= htmlspecialchars($student['room_number']) ?></td>
                <td><?= htmlspecialchars($student['status']) ?></td>
                <td><a href="update_student.php?id=<?= $student['id'] ?>">Update</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="text-center">
        <a href="dashboard.php" class="btn btn-danger">Back to Dashboard</a>
    </div>
    <?php include 'footer.php'; ?>

</body>

</html>