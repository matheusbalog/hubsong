<?php
session_start();
include "config.php";

// Apenas verifica se está logado
if (!isset($_SESSION['user_id'])) {
    die("Acesso não autorizado.");
}

$artist_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT 
        songs.id,
        songs.title,
        songs.uploaded_at,
        ROUND(AVG(review_scores.score), 1) AS media
    FROM songs
    LEFT JOIN reviews ON reviews.song_id = songs.id
    LEFT JOIN review_scores ON review_scores.review_id = reviews.id
    WHERE songs.artist_id = ?
    GROUP BY songs.id
    ORDER BY songs.uploaded_at DESC
");
$stmt->bind_param("i", $artist_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include "header.php"; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Minhas Músicas – TuneTest</title>

<style>
:root{
    --roxo:#ccff00;
    --azul:#ccff00;
    --preto:#000;
    --card:#151515;
    --cinza:#111;
    --borda:rgba(255,255,255,.15);
}

html, body{
    margin:0;
    padding:0;
    width:100%;
    min-height:100%;
    background:var(--preto);
    font-family:Inter, Arial, sans-serif;
    color:#fff;
}

.container{
    max-width:1000px;
    margin:40px auto;
    padding:0 20px;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.page-header h2{
    margin:0;
    font-size:24px;
}

.page-header a{
    text-decoration:none;
    color:#fff;
    background:var(--card);
    border:1px solid var(--borda);
    padding:10px 14px;
    border-radius:10px;
    font-size:14px;
    transition:.25s;
}

.page-header a:hover{
    border-color:var(--roxo);
    color:var(--roxo);
}

/* ===== LISTA ===== */
.song-list{
    display:flex;
    flex-direction:column;
    gap:16px;
}

.song-card{
    background:var(--card);
    border:1px solid var(--borda);
    border-radius:16px;
    padding:18px 20px;
    transition:.25s;
}

.song-card:hover{
    border-color:var(--azul);
    transform:translateY(-2px);
}

/* ===== HEADER ===== */
.song-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.song-title{
    font-size:17px;
    font-weight:600;
}

.song-date{
    font-size:13px;
    opacity:.65;
}

/* ===== SCORE ===== */
.score-box{
    margin-top:10px;
    font-size:14px;
    opacity:.9;
}

.score-box strong{
    margin-left:6px;
}

/* ===== ACTIONS ===== */
.song-actions{
    margin-top:14px;
}

.song-actions a{
    text-decoration:none;
    font-size:14px;
    color:var(--azul);
}

.song-actions a:hover{
    text-decoration:underline;
}

.empty{
    margin-top:40px;
    opacity:.7;
}
</style>
</head>

<body>

<div class="container">

    <div class="page-header">
        <h2>🎵 Minhas músicas</h2>
        <div>
            <a href="index.php">← Feed</a>
            <a href="upload.php">+ Nova música</a>
        </div>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <div class="song-list">
            <?php while ($song = $result->fetch_assoc()): ?>
                <div class="song-card">

                    <div class="song-header">
                        <div class="song-title">
                            <?php echo htmlspecialchars($song['title']); ?>
                        </div>
                        <div class="song-date">
                            <?php echo date("d/m/Y", strtotime($song['uploaded_at'])); ?>
                        </div>
                    </div>

                    <div class="score-box">
                        Nota geral:
                        <strong>
                            <?php echo $song['media'] ? "⭐ ".$song['media']." / 10" : "Sem avaliações"; ?>
                        </strong>
                    </div>

                    <div class="song-actions">
                        <a href="song.php?id=<?php echo $song['id']; ?>">
                            Ver avaliações detalhadas →
                        </a>
                    </div>

                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="empty">Você ainda não enviou nenhuma música.</p>
    <?php endif; ?>

</div>

</body>
</html>
