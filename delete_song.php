<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'artist') {
    header("Location: login.php");
    exit;
}

if(isset($_GET['id'])) {
    $song_id = intval($_GET['id']);
    $artist_id = $_SESSION['user_id'];

    // Busca a música para garantir que pertence ao artista
    $stmt = $conn->prepare("SELECT filename FROM songs WHERE id = ? AND artist_id = ?");
    $stmt->bind_param("ii", $song_id, $artist_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $song = $result->fetch_assoc();
        $file_path = "uploads/" . $song['filename'];

        // Deleta o arquivo físico
        if(file_exists($file_path)) {
            unlink($file_path);
        }

        // Deleta do banco
        $stmt = $conn->prepare("DELETE FROM songs WHERE id = ? AND artist_id = ?");
        $stmt->bind_param("ii", $song_id, $artist_id);
        $stmt->execute();
    }
}

// Redireciona para o feed
header("Location: index.php");
exit;
?>
