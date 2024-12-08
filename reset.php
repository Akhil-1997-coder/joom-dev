<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE users SET password = '$hashed_password', last_password_change = NOW() WHERE id = $user_id";

        if (mysqli_query($conn, $sql)) {
            echo "Password updated successfully!";
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error updating password.";
        }
    } else {
        echo "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <form method="POST" action="">
        <p>New Password</p>
        <input type="password" name="new_password" required />
        <p>Confirm Password</p>
        <input type="password" name="confirm_password" required />
        <br><br>
        <button type="submit">Update Password</button>
    </form>
</body>
</html>
