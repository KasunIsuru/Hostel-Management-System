<?php
session_start();
include 'config/db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verify user credentials
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on user role
        if ($user['role'] == 'student') {
            header("Location: student/dashboard.php");
        } elseif ($user['role'] == 'warden') {
            header("Location: warden/dashboard.php");
        } elseif ($user['role'] == 'security') {
            header("Location: security/dashboard.php");
        }
        exit();
    } else {
        $message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .container {
            max-width: auto;
            margin: 0 auto;
            padding: 20px;

        }

        /* body,
        html {
            height: 100%;
            font-family: Arial, Helvetica, sans-serif;
        } */

        .bg-img {
            background-image: url("https://images.pexels.com/photos/674010/pexels-photo-674010.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1");
            background-color: black;
            min-height: 100vh;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 9px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 1000px;
            height: auto;
            width: 100%;
        }

        label {
            font-size: larger;
        }

        /* 
        .col {
            align-content: center;
        } */


        /* The flip box container - set the width and height to whatever you want. We have added the border property to demonstrate that the flip itself goes out of the box on hover (remove perspective if you don't want the 3D effect */
        .flip-box {
            background-color: transparent;
            width: auto;
            height: 260px;
            border: 1px solid #f1f1f1;
            perspective: 1000px;
            /* Remove this if you don't want the 3D effect */
        }

        /* This container is needed to position the front and back side */
        .flip-box-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }

        /* Do an horizontal flip when you move the mouse over the flip box container */
        .flip-box:hover .flip-box-inner {
            transform: rotateY(180deg);
        }

        /* Position the front and back side */
        .flip-box-front,
        .flip-box-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            /* Safari */
            backface-visibility: hidden;
        }

        /* Style the front side (fallback if image is missing) */
        .flip-box-front {
            background-color: #bbb;
            color: black;
        }

        /* Style the back side */
        .flip-box-back {
            background-color: dodgerblue;
            color: white;
            transform: rotateY(180deg);
            align-content: center;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="bg-img">
        <div class="form-container mt-5 mb-5">
            <h1 class="text-center mb-4">Login</h1>

            <?php if ($message): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <div class="row g-4">

                <!-- Column 1 -->
                <div class="col p-3">
                    <div class="card">
                        <!-- <img src="./Images/img/student_img/View Your Details.png" alt="USER LOGO" height="260px"> -->
                        <div class="flip-box">
                            <div class="flip-box-inner">
                                <div class="flip-box-front">
                                    <img src="./Images/img/student_img/View Your Details.png" alt="Paris" style="width:100%;height:260px">
                                </div>
                                <div class="flip-box-back">
                                    <h2>Hello</h2>
                                    <p>Welcome to hostel management system</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="col p-3">
                    <form method="POST">
                        <div class="mb-4">
                            <label for="username" class="mb-2">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="mb-2">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-4">Login</button>
                    </form>
                </div>
            </div>


        </div>


    </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>