<?php
session_start();
include "../partials/db.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    $email_esc = mysqli_real_escape_string($conn, $email);
    $sql = "SELECT id FROM users WHERE email = '{$email_esc}' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0){
        $_SESSION['reset_email'] = $email;
        header('Location: resetPassword.html');
        exit;
    }
    
    echo 'If that account exists, you will be taken to reset password.';
}
?>