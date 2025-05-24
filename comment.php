<?php
session_start();
require_once '../partials/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../authentification/login.php");
    exit;
}

if (!isset($_POST['post_id']) || !ctype_digit($_POST['post_id']) || empty(trim($_POST['comment']))) {
    die("Invalid input.");
}

$post_id = (int) $_POST['post_id'];
$user_id = (int) $_SESSION['user_id'];
$comment_text = trim($_POST['comment']);

$sql = "INSERT INTO comments (post_id, user_id, comment, commented_at)
        VALUES ($post_id, $user_id, '$comment_text', NOW())";

if (!mysqli_query($conn, $sql)) {
    die("Database error: " . mysqli_error($conn));
}

header("Location: ../post.php?id=$post_id");
exit;
?>