<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    die("Não autorizado.");
}

$song_id = intval($_POST['song_id']);
$user_id = $_SESSION['user_id'];
$scores = $_POST['scores'];

$conn->begin_transaction();

try {
    // 1. Cria a Review principal
    $stmt = $conn->prepare("INSERT INTO reviews (song_id, reviewer_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $song_id, $user_id);
    $stmt->execute();
    $review_id = $conn->insert_id;

    // 2. Insere os detalhes técnicos (Scores)
    $stmtScore = $conn->prepare("
        INSERT INTO review_scores (review_id, factor, score, comment)
        VALUES (?, ?, ?, ?)
    ");

    foreach ($scores as $factor => $data) {
        $stmtScore->bind_param(
            "isis",
            $review_id,
            $factor,
            $data['score'],
            $data['comment']
        );
        $stmtScore->execute();
    }

    // --- LOGICA DE KARMA ---
    // 3. Aumenta +1 de Karma para quem avaliou
    $updateKarma = $conn->prepare("UPDATE users SET karma = karma + 1 WHERE id = ?");
    $updateKarma->bind_param("i", $user_id);
    $updateKarma->execute();
    // -----------------------

    // Se chegou aqui sem erros, salva tudo definitivamente
    $conn->commit();

    header("Location: song.php?id=".$song_id);
    exit;

} catch (Exception $e) {
    // Se der qualquer erro, cancela tudo o que foi feito acima
    $conn->rollback();
    die("Erro ao salvar avaliação: " . $e->getMessage());
}