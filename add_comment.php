<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if(isset($_POST['song_id']) && isset($_POST['comment'])) {
    $song_id = intval($_POST['song_id']);
    $user_id = $_SESSION['user_id'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO comments (song_id, user_id, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $song_id, $user_id, $comment);
    $stmt->execute();
}

header("Location: index.php");
exit;
?>
