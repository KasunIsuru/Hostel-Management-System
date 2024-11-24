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
    <h1>Hostel Management System</h1>
    <div class="card deck">
        <div class="card" style="width: 18rem;">
            <img src="xampp\htdocs\Hostel-Management-System\assets\img\login card.jpg" class="card-img-top" alt="USER LOGO">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="login.php?role=warden" class="btn btn-primary">Warden Login</a>
            </div>
        </div>

        <div class="card" style="width: 18rem;">
            <img src="xampp\htdocs\Hostel-Management-System\assets\img\login card.jpg" class="card-img-top" alt="USER LOGO">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="login.php?role=student" class="btn btn-primary">Student Login</a>
            </div>
        </div>

        <div class="card" style="width: 18rem;">
            <img src="xampp\htdocs\Hostel-Management-System\assets\img\login card.jpg" class="card-img-top" alt="USER LOGO">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="login.php?role=security" class="btn btn-primary">Security Login</a>
            </div>
        </div>
    </div>
    <!-- <a href="login.php?role=warden">Warden Login</a><br> -->
    <!-- <a href="login.php?role=student">Student Login</a><br> -->
    <!-- <a href="login.php?role=security">Security Login</a> -->

    <?php include 'footer.php'; ?>
</body>

</html>