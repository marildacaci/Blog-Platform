<?php
session_start();
include "../partials/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method.";
    exit();
}

$firstname = mysqli_real_escape_string($conn, trim($_POST['firstname'] ?? ''));
$lastname = mysqli_real_escape_string($conn, trim($_POST['lastname'] ?? ''));
$username = mysqli_real_escape_string($conn, trim($_POST['username'] ?? ''));
$email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
$password = trim($_POST['password'] ?? '');
$confirmPassword = trim($_POST['confirm_password'] ?? '');

$errors = [];

if (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters long.";
}

if ($password !== $confirmPassword) {
    $errors[] = "Passwords do not match.";
}

$checkSql = "SELECT id FROM users WHERE username = '$username' OR email = '$email' LIMIT 1";
$checkRes = mysqli_query($conn, $checkSql);

if (!$checkRes) {
    echo "Database error: " . mysqli_error($conn);
    exit();
}

if (mysqli_num_rows($checkRes) > 0) {
    $errors[] = "Username or email already exists.";
}

if (!empty($errors)) {
    foreach ($errors as $err) {
        echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8') . "<br>";
    }
    exit();
}

$roleId = 2;

$insertSql = "INSERT INTO users (role_id, firstname, lastname, username, email, password) 
    VALUES ($roleId, '$firstname', '$lastname', '$username', '$email', '$password')";

if (mysqli_query($conn, $insertSql)) {
    echo 'Your account has been registered successfully. <a href="login.html">Login</a>';
    exit();
} else {
    echo "Error inserting user: " . mysqli_error($conn);
    exit();
}

mysqli_close($conn)
?>
