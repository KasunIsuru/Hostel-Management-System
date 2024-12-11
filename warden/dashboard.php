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
        <h1 class="text-center mb-4">Welcome, Warden</h1>

        <table>
            <tbody>
                <tr>
                    <div class="row gy-3">
                        <div class="col-md-4">
                            <div class="card">
                                <img src="./images/img/warden.png" class="card-img-top" alt="USER LOGO" height="324px">
                                <div class="card-body">
                                    <center><a href="register_student.php" class="btn btn-primary">Register Student</a></center>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <img src="./images/img/Student.png" class="card-img-top" alt="USER LOGO" height="324px">
                                <div class="card-body">
                                    <center><a href="view_students.php" class="btn btn-primary">Register Student</a></center>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <img src="./images/img/Student.png" class="card-img-top" alt="USER LOGO" height="324px">
                                <div class="card-body">
                                    <center><a href="room_management.php" class="btn btn-primary">Student Login</a></center>
                                </div>
                            </div>
                        </div>
                    </div>

                </tr>
                <tr>
                    <div class="row gy-3">
                        <div class="col-md-4">
                            <div class="card">
                                <img src="./images/img/Student.png" class="card-img-top" alt="USER LOGO" height="324px">
                                <div class="card-body">
                                    <center><a href="view_late_requests.php" class="btn btn-primary">view_late_requests.php</a></center>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <img src="./images/img/Student.png" class="card-img-top" alt="USER LOGO" height="324px">
                                <div class="card-body">
                                    <center><a href="security_attendance.php" class="btn btn-primary">Mark Security Attendance</a></center>
                                </div>
                            </div>
                        </div>
                    </div>

                </tr>
            </tbody>
        </table>



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