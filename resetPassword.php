<?php
session_start();
include '../partials/db.php';

if (empty($_SESSION['reset_email'])) {
    header('Location: forgotPassword.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirmPass = isset($_POST['confirm_new_password']) ? $_POST['confirm_new_password'] : '';

    if (empty($pass) || empty($confirmPass)) {
        die('All fields are required.');
    }
    if ($pass !== $confirmPass) {
        die('Passwords do not match.');
    }

    $email = $_SESSION['reset_email'];
    $email_esc = mysqli_real_escape_string($conn, $email);
    $pass_esc = mysqli_real_escape_string($conn, $pass);

    $sql = "UPDATE users SET password = '{$pass_esc}' WHERE email = '{$email_esc}'";
    mysqli_query($conn, $sql);

    unset($_SESSION['reset_email']);

    echo 'Your password has been reset successfully. <a href="login.html">Login</a>';
    exit;
}
?>