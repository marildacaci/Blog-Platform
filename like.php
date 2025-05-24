<?php
session_start();
require_once '../partials/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../authentification/login.php");
    exit;
}

if (!isset($_POST['post_id']) || !ctype_digit($_POST['post_id'])) {
    die("Invalid post ID.");
}

$post_id = (int) $_POST['post_id'];
$user_id = (int) $_SESSION['user_id'];

$sql = "SELECT likes_post_id, likes_user_id, liked_at
        FROM likes
        WHERE likes_post_id = $post_id AND likes_user_id = $user_id";
        
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    $sql_insert = "INSERT INTO likes (likes_post_id, likes_user_id, liked_at)
                   VALUES ($post_id, $user_id, NOW())";
    mysqli_query($conn, $sql_insert);
} else {
    $sql_delete = "DELETE FROM likes
                   WHERE likes_post_id = $post_id AND likes_user_id = $user_id";
    mysqli_query($conn, $sql_delete);
}

header("Location: ../post.php?id=$post_id");
exit;
?>