<?php
$dbHostName = "127.0.0.1";
$dbUsername = "root";
$dbPassword = "rootroot";
$db = "blogplatform";

$conn = mysqli_connect($dbHostName, $dbUsername, $dbPassword, $db);

if (!$conn) {
    echo "Probleme me lidhjen: " . mysqli_connect_errno();
    exit;
}
?>
