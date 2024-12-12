<?php
$cssPath = "../styles/styles.css";
session_start();
if ($_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
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
                            <a href="view_details.php" class="btn btn-primary">View Your Details</a>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <div class="card text-center h-90 shadow-sm">
                    <img src="..\Images\img\student_img\View Room Details.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="room_details.php" class="btn btn-primary">View Room Details</a>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <div class="card text-center h-90 shadow-sm">
                    <img src="..\Images\img\student_img\Submit Late Attendance.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="late_request.php" class="btn btn-primary">Submit Late Attendance</a>
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
                            <a href="change_password.php" class="btn btn-primary">Change Password</a>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <div class="card text-center h-90 shadow-sm" id="card4">
                    <img src="../Images/img/student_img/View Late Attendance.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="student_view_late_requests.php" class="btn btn-primary">View Late Attendance</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="../logout.php" class="btn btn-danger">Logout</a>
        </div>

    </div>

    <?php include 'footer.php'; ?>

</body>

</html>