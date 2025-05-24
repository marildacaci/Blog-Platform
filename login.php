<?php
session_start();
include "../partials/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.html");
    exit();
}

$email_or_username = isset($_POST['email_or_username']) ? trim($_POST['email_or_username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

$sql = "SELECT users.id AS user_id, users.username, users.email, roles.name
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE (users.email = '$email_or_username' OR users.username = '$email_or_username')";

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Database error: " . mysqli_error($conn);
    exit();
}

if (mysqli_num_rows($result) === 0) {
    echo "Invalid credentials. Please try again.<br>";
    echo "<a href='login.html'>Back to Login</a>";
    exit();
}

$row = mysqli_fetch_assoc($result);
mysqli_free_result($result);

$_SESSION['user_id'] = $row['user_id'];
$_SESSION['user_name'] = $row['username'];
$_SESSION['user_email'] = $row['email'];
$_SESSION['user_role'] = $row['name'];

header("Location: ../profile.php");
exit();
