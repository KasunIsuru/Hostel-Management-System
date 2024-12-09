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
        <h1 class="text-center mb-4">Welcome, Student</h1>

        <!-- First Row: 3 Cards -->
        <div class="row row-cols-1 row-cols-md-3 g-4">

            <div class="col">
                <div class="card text-center h-100 shadow-sm">
                    <img src="./images/img/warden.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="view_details.php" class="btn btn-primary">View Your Details</a>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-center h-100 shadow-sm">
                    <img src="./images/img/warden.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="room_details.php" class="btn btn-primary">View Room Details</a>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-center h-100 shadow-sm">
                    <img src="./images/img/warden.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="late_request.php" class="btn btn-primary">Submit Late Attendance Request</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row: 2 Cards -->
        <div class="row row-cols-1 row-cols-md-2 g-4 mt-4 mb-4">
            <div class="col">
                <div class="card text-center h-100 shadow-sm">
                    <img src="./images/img/warden.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="change_password.php" class="btn btn-primary">Change Password</a>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-center h-100 shadow-sm">
                    <img src="./images/img/warden.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="student_view_late_requests.php" class="btn btn-primary">View Late Attendance Request</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="../logout.php" class="btn btn-danger">Back to Dashboard</a>
        </div>

    </div>


    <!-- <h1>Welcome, Student</h1>
    <a href="view_details.php">View Your Details</a><br>
    <a href="room_details.php">View Room Details</a><br>
    <a href="late_request.php">Submit Late Attendance Request</a><br>
    <a href="change_password.php">Change Password</a><br>
    <a href="student_view_late_requests.php">View Late Attendance Request</a><br>
    <a href="../logout.php">Logout</a> -->
    <?php include 'footer.php'; ?>

</body>

</html>