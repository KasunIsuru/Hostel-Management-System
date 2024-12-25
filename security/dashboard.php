<?php
$cssPath = "../styles/styles.css";
session_start();
if ($_SESSION['role'] != 'security') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Security Dashboard</title>
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
        <h1 class="text-center mb-4">Welcome, Security</h1>


        <div class="row justify-content-center g-1">

            <div class="col-auto">
                <div class="card text-center h-90 shadow-sm">
                    <img src="..\Images\img\student_img\View Your Details.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <center>
                            <a href="mark_attendance.php" class="btn btn-primary">View Your Details</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="../logout.php" class="btn btn-danger mt-4">Logout</a>
        </div>

    </div>

    <?php include 'footer.php'; ?>

</body>

</html>