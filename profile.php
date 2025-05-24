<?php
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ./authentification/login.html");
    exit();
}

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_email'])) {
    header("Location: ./authentification/login.html");
    exit();
}

$username = htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8');
$role = htmlspecialchars($_SESSION['user_role'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link rel="stylesheet" href="./public/styles/style.css">
</head>

<body>

    <div class="profile-container">
        <h2>Welcome, <?php echo $username; ?>!</h2>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Role:</strong> <?php echo $role; ?></p>
        <p><a href="home.php">Go to homepage</a></p>

        <form method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>

</body>

</html>
