<?php
session_start();
$cssPath = "../styles/styles.css";
include '../config/db.php';

// Ensure the logged-in user is a student
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $username = $_SESSION['username']; // Logged-in student's username

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $message = "<p style='color: red;'>All fields are required!</p>";
    } elseif ($new_password !== $confirm_password) {
        $message = "<p style='color: red;'>New password and confirm password do not match!</p>";
    } else {
        try {
            // Fetch the current password for the logged-in user
            $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ? AND role = 'student'");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || $user['password'] !== $current_password) {
                $message = "<p style='color: red;'>Current password is incorrect!</p>";
            } else {
                // Update the password
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ? AND role = 'student'");
                $stmt->execute([$new_password, $username]);
                $message = "<p style='color: green;'>Password updated successfully!</p>";
            }
        } catch (Exception $e) {
            $message = "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }
    }
}
?>

<!-- front end -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
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
        <h1 class="text-center mb-4">Change Password</h1>

        <?php if ($message): ?>
            <div class="alert alert-success text-center">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">change password</div>
            <div class="card-body">

                <table>
                    <tbody>
                        <tr>
                            <th>Current Password</th>
                            <td> <input type="password" id="current_password" class="form-control mr-2" name="current_password" required></td>
                        </tr>
                        <tr>
                            <th>New Password</th>
                            <td> <input type="password" id="new_password" class="form-control mr-2" name="new_password" required></td>
                        </tr>
                        <tr>
                            <th>Confirm New Password</th>
                            <td> <input type="password" id="confirm_password" class="form-control mr-2" name="confirm_password" required></td>
                        </tr>
                        <tr>
                            <td colspan="2"><button type="submit" class="btn btn-primary">Change Password</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center">
            <a href="dashboard.php" class="btn btn-danger">Back to Dashboard</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>