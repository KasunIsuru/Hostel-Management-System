<?php
$cssPath = "../styles/styles.css";

session_start();
if ($_SESSION['role'] != 'warden') {
    header("Location: ../login.php");
    exit();
}
?>

<!-- front end -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Warden Dashboard</title>
    <link rel="stylesheet" href="<?php echo $cssPath; ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <style>
        .container {
            max-width: auto;
            margin: 0 auto;
            padding: 20px;

        }
    </style>

</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1 class="text-center mb-4">Welcome, Student</h1>

        <!-- First Row: 3 Cards -->
        <div class="row justify-content-center g-1">

            <div class="col-auto">
                <div class="card text-center h-90 shadow-sm">
                    <img src="..\Images\img\student_img\View Your Details.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="register_student.php" class="btn btn-primary">register student</a>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <div class="card text-center h-90 shadow-sm">
                    <img src="..\Images\img\student_img\View Room Details.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="view_students.php" class="btn btn-primary">view students</a>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <div class="card text-center h-90 shadow-sm">
                    <img src="..\Images\img\student_img\Submit Late Attendance.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="room_management.php" class="btn btn-primary">room management</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row: 2 Cards -->
        <div class="row justify-content-center g-1 mt-4 mb-4">

            <div class="col-auto">
                <div class="card text-center h-90 shadow-sm" id="card4">
                    <img src="..\Images\img\student_img\Change Password.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="view_late_requests.php" class="btn btn-primary">late requests</a>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <div class="card text-center h-90 shadow-sm" id="card4">
                    <img src="../Images/img/student_img/View Late Attendance.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="security_attendance.php" class="btn btn-primary">Mark Security Attendance</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>


        <div class="text-center">
            <a href="../logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- <a href="register_student.php">Register Student</a><br>
    <a href="view_students.php">View/Search Students</a><br>
    <a href="room_management.php">Manage Rooms</a><br>
    <a href="view_late_requests.php">View Late Attendance Requests</a><br>
    <a href="security_attendance.php">Mark Security Attendance</a><br>
    <a href="../logout.php">Logout</a> -->

    <?php include 'footer.php'; ?>
</body>

</html>