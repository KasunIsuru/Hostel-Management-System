<?php
session_start();
include 'config/db.php';

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
        echo "<p style='color: red;'>Invalid username or password!</p>";
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
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="bg-img">
        <div class="form-container mt-4 mb-4">
            <h1 class="text-center mb-4">Login</h1>
            <div class="row g-4">

                <!-- Column 1 -->
                <div class="col">
                    <div class="card">
                        <img src="./Images/img/student_img/View Your Details.png" alt="USER LOGO" height="260px">
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="col">
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