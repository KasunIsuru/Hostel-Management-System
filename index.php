<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <title>Hostel Management System</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <h1 class="text-center mt-4">Hostel Management System</h1>
    <!-- card section  -->

    <div class="container p-5">

        <div class="row gy-3">
            <div class="col-md-4">
                <div class="card">
                    <img src="./images/img/warden.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                        <a href="login.php?role=warden" class="btn btn-primary ">Warden Login</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <img src="./images/img/Student.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                        <a href="login.php?role=student" class="btn btn-primary">Student Login</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <img src="./images/img/Security.png" class="card-img-top" alt="USER LOGO" height="324px">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                        <a href="login.php?role=security" class="btn btn-primary">Security Login</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include 'footer.php'; ?>
</body>

</html>