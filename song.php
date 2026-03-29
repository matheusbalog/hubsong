<?php
session_start();
include "config.php";

if (!isset($_GET['id'])) {
    die("Música não encontrada.");
}

$song_id = intval($_GET['id']);

/* BUSCA MÚSICA + ARTISTA */
$stmt = $conn->prepare("
    SELECT songs.*, users.name AS artist_name, users.avatar, users.id AS artist_id
    FROM songs
    JOIN users ON songs.artist_id = users.id
    WHERE songs.id = ?
");
$stmt->bind_param("i", $song_id);
$stmt->execute();
$song = $stmt->get_result()->fetch_assoc();

if (!$song) {
    die("Música não encontrada.");
}

/* MÉDIA GERAL */
$avgQuery = $conn->prepare("
    SELECT AVG(score) AS media
    FROM review_scores
    JOIN reviews ON reviews.id = review_scores.review_id
    WHERE reviews.song_id = ?
");
$avgQuery->bind_param("i", $song_id);
$avgQuery->execute();
$media = number_format($avgQuery->get_result()->fetch_assoc()['media'], 1);
/* MÉDIA POR FATOR PARA O GRÁFICO */
$factorsQuery = $conn->prepare("
    SELECT factor, AVG(score) as avg_score 
    FROM review_scores 
    JOIN reviews ON reviews.id = review_scores.review_id 
    WHERE reviews.song_id = ? 
    GROUP BY factor
");
$factorsQuery->bind_param("i", $song_id);
$factorsQuery->execute();
$factorsResult = $factorsQuery->get_result();

$chartData = ["composicao"=>0, "letra"=>0, "producao"=>0, "arranjo"=>0, "performance"=>0];
while($row = $factorsResult->fetch_assoc()){
    $chartData[$row['factor']] = round($row['avg_score'], 1);
}

/* CONTROLE DE SESSÃO */
$logado   = isset($_SESSION['user_id']);
$is_owner = $logado && $_SESSION['user_id'] == $song['artist_id'];

/* VERIFICA SE JÁ AVALIOU */
$ja_avaliou = false;
if ($logado) {
    $check = $conn->prepare("SELECT id FROM reviews WHERE song_id = ? AND reviewer_id = ?");
    $check->bind_param("ii", $song_id, $_SESSION['user_id']);
    $check->execute();
    $ja_avaliou = $check->get_result()->num_rows > 0;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($song['title']); ?> – TuneTest</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --imdb-black: #000000;
            --imdb-dark-gray: #121212;
            --imdb-gray: #1f1f1f;
            --imdb-yellow: #ccff00;
            --text-white: #ffffff;
            --text-muted: #b3b3b3;
            --border: rgba(255,255,255,0.1);
            --player-height: 90px;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            background-color: var(--imdb-black);
            color: var(--text-white);
            font-family: 'Roboto', sans-serif;
            line-height: 1.5;
            padding-bottom: calc(var(--player-height) + 40px);
        }

        .main-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        /* HERO SECTION */
        .song-hero {
            background-color: var(--imdb-dark-gray);
            padding: 30px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .hero-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
        }

        .hero-titles h1 { font-size: clamp(24px, 5vw, 40px); margin: 0; font-weight: 700; }
        .sub-meta { color: var(--text-muted); font-size: 14px; margin-top: 5px; }

        .imdb-rating-box { text-align: right; }
        .rating-label { text-transform: uppercase; font-size: 11px; font-weight: 700; color: var(--text-muted); letter-spacing: 1px; }
        .rating-value { display: flex; align-items: center; gap: 5px; font-size: 28px; font-weight: 700; justify-content: flex-end;}
        .rating-value span { color: var(--text-muted); font-size: 18px; font-weight: 400; }

        /* SISTEMA DE BOLAS */
        .rating-pills {
            display: flex;
            gap: 8px;
            margin: 15px 0;
            flex-wrap: wrap;
        }

        .pill {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            transition: 0.2s;
            background: transparent;
            color: var(--text-muted);
        }

        .pill:hover { border-color: var(--imdb-yellow); color: #fff; }
        .pill.active {
            background: var(--imdb-yellow);
            border-color: var(--imdb-yellow);
            color: #000;
            transform: scale(1.1);
        }

        .score-input-hidden { opacity: 0; position: absolute; pointer-events: none; }

        /* SEÇÕES */
        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid var(--imdb-yellow);
            padding-left: 10px;
            margin: 40px 0 20px;
            font-size: 22px;
        }

        .factor-input { background: var(--imdb-gray); padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid var(--border); }
        textarea { width: 100%; background: #000; border: 1px solid #333; color: white; padding: 12px; border-radius: 4px; margin-top: 8px; resize: vertical; }
        .btn-submit { background: var(--imdb-yellow); color: black; border: none; padding: 15px; font-weight: 800; border-radius: 50px; cursor: pointer; text-transform: uppercase; width: 100%; }

        .review-card { background-color: var(--imdb-gray); border: 1px solid var(--border); border-radius: 8px; margin-bottom: 12px; }
        .review-header { padding: 15px 20px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
        .review-body { display: none; padding: 20px; background-color: #151515; border-top: 1px solid var(--border); }

        /* PLAYER */
        .fixed-player {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: var(--player-height);
            background: #111;
            border-top: 1px solid var(--border);
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            align-items: center;
            padding: 0 20px;
            z-index: 1000;
        }
        .player-controls { display: flex; flex-direction: column; align-items: center; gap: 5px; }
        .play-btn { background: white; border: none; color: black; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; }
        .progress-container { width: 100%; max-width: 400px; display: flex; align-items: center; gap: 10px; font-size: 11px; }
        #progress { flex: 1; accent-color: var(--imdb-yellow); }

        @media (max-width: 768px) {
            .fixed-player { grid-template-columns: 1fr; }
            .player-info, .player-volume { display: none; }
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="main-container">
    <div class="song-hero">
        <div class="hero-top">
            <div class="hero-titles">
                <h1><?php echo htmlspecialchars($song['title']); ?></h1>
                <div class="sub-meta">Artista: <strong style="color:white"><?php echo htmlspecialchars($song['artist_name']); ?></strong></div>
            </div>
            <div class="imdb-rating-box">
                <div class="rating-label">Média HubSong</div>
                <div class="rating-value"><span style="color:var(--imdb-yellow)">★</span> <?php echo ($media > 0) ? $media : "—"; ?><span>/10</span></div>
            </div>
        </div>
    </div>
<div class="factor-input" style="background: var(--imdb-dark-gray); display: flex; justify-content: center; padding: 20px;">
    <div style="width: 100%; max-width: 400px;">
        <canvas id="radarChart"></canvas>
    </div>
</div>
    <h2 class="section-title">Avaliações Técnicas</h2>

    <?php if ($logado): ?>
        <?php if ($is_owner): ?>
            <?php
            $fb = $conn->prepare("
                SELECT users.name AS reviewer, review_scores.factor, review_scores.score, review_scores.comment
                FROM review_scores
                JOIN reviews ON reviews.id = review_scores.review_id
                JOIN users ON users.id = reviews.reviewer_id
                WHERE reviews.song_id = ?
                ORDER BY reviews.id DESC
            ");
            $fb->bind_param("i",$song_id);
            $fb->execute();
            $res = $fb->get_result();
            $avaliacoes = [];
            while($r = $res->fetch_assoc()){ $avaliacoes[$r['reviewer']][] = $r; }

            if (empty($avaliacoes)): ?>
                <p>Aguardando avaliações...</p>
            <?php else: 
                foreach($avaliacoes as $reviewer => $itens): ?>
                <div class="review-card">
                    <div class="review-header" onclick="toggleReview(this)">
                        <span style="color:var(--imdb-yellow); font-weight:700;"><?php echo htmlspecialchars($reviewer); ?></span>
                        <span class="arrow-icon">▼</span>
                    </div>
                    <div class="review-body">
                        <?php foreach($itens as $item): ?>
                            <div style="margin-bottom:15px; border-bottom:1px solid #333; padding-bottom:10px;">
                                <div style="color:var(--imdb-yellow); font-size:12px;"><strong><?php echo strtoupper($item['factor']); ?></strong> — <?php echo $item['score']; ?>/10</div>
                                <div style="color:#ccc; font-size:14px;"><?php echo nl2br(htmlspecialchars($item['comment'])); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

        <?php elseif ($ja_avaliou): ?>
            <div class="factor-input">Sua avaliação já foi enviada!</div>
        <?php else: ?>
            <form id="reviewForm" method="post" action="submit_review.php">
                <input type="hidden" name="song_id" value="<?php echo $song_id; ?>">
                <?php
                $fatores = ["composicao"=>"Composição", "letra"=>"Letra", "producao"=>"Produção", "arranjo"=>"Arranjo", "performance"=>"Performance"];
                foreach($fatores as $key=>$label): ?>
                    <div class="factor-input">
                        <label><strong><?php echo $label; ?></strong></label>
                        <div class="rating-pills" data-factor="<?php echo $key; ?>">
                            <?php for($i=1; $i<=10; $i++): ?>
                                <div class="pill" onclick="setScore('<?php echo $key; ?>', <?php echo $i; ?>, this)"><?php echo $i; ?></div>
                            <?php endfor; ?>
                        </div>
                        <input type="number" name="scores[<?php echo $key; ?>][score]" id="input-<?php echo $key; ?>" class="score-input-hidden" required>
                        <textarea name="scores[<?php echo $key; ?>][comment]" placeholder="Feedback sobre <?php echo strtolower($label); ?>..." required></textarea>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn-submit">Publicar Avaliação</button>
            </form>
        <?php endif; ?>
    <?php else: ?>
        <div class="factor-input">Faça login para avaliar.</div>
    <?php endif; ?>
</div>

<div class="fixed-player">
    <div class="player-info">
        <div class="info-text">
            <h4><?php echo htmlspecialchars($song['title']); ?></h4>
            <p><?php echo htmlspecialchars($song['artist_name']); ?></p>
        </div>
    </div>
    <div class="player-controls">
        <button id="playBtn" class="play-btn">▶</button>
        <div class="progress-container">
            <span id="currentTime">0:00</span>
            <input type="range" id="progress" min="0" max="100" value="0">
            <span id="duration">0:00</span>
        </div>
    </div>
    <div class="player-volume">
        <input type="range" id="volume" min="0" max="1" step="0.01" value="0.8">
    </div>
</div>

<script>
    // SISTEMA DE NOTAS
    function setScore(factor, value, element) {
        // Define o valor no input que o PHP vai ler
        const hiddenInput = document.getElementById('input-' + factor);
        hiddenInput.value = value;
        
        // Remove 'active' de todas as bolas do grupo
        const pills = element.parentElement.querySelectorAll('.pill');
        pills.forEach(p => p.classList.remove('active'));
        
        // Ativa a bola clicada
        element.classList.add('active');
    }

    // AUDIO PLAYER
    const player = new Howl({
        src: ['uploads/<?php echo rawurlencode($song['filename']); ?>'],
        html5: true,
        onplay: () => { 
            playBtn.innerText = '⏸'; 
            requestAnimationFrame(updateProgress); 
        },
        onpause: () => playBtn.innerText = '▶',
        onload: () => duration.innerText = format(player.duration())
    });

    const playBtn = document.getElementById('playBtn');
    const progress = document.getElementById('progress');
    const currentTime = document.getElementById('currentTime');
    const duration = document.getElementById('duration');

    playBtn.onclick = () => player.playing() ? player.pause() : player.play();
    document.getElementById('volume').oninput = (e) => player.volume(e.target.value);
    progress.oninput = (e) => player.seek(player.duration() * (e.target.value / 100));

    function updateProgress() {
        if (!player.playing()) return;
        const seek = player.seek() || 0;
        progress.value = (seek / player.duration()) * 100 || 0;
        currentTime.innerText = format(seek);
        requestAnimationFrame(updateProgress);
    }

    function format(s) {
        const m = Math.floor(s / 60) || 0;
        const sec = Math.floor(s % 60) || 0;
        return `${m}:${sec < 10 ? '0' : ''}${sec}`;
    }

    function toggleReview(header) {
        const body = header.nextElementSibling;
        body.style.display = body.style.display === "block" ? "none" : "block";
    }
    const ctx = document.getElementById('radarChart').getContext('2d');
new Chart(ctx, {
    type: 'radar',
    data: {
        labels: ['Composição', 'Letra', 'Produção', 'Arranjo', 'Performance'],
        datasets: [{
            label: 'Desempenho Técnico',
            data: [
                <?php echo $chartData['composicao']; ?>,
                <?php echo $chartData['letra']; ?>,
                <?php echo $chartData['producao']; ?>,
                <?php echo $chartData['arranjo']; ?>,
                <?php echo $chartData['performance']; ?>
            ],
            fill: true,
            backgroundColor: 'rgba(204, 255, 0, 0.2)',
            borderColor: '#ccff00',
            pointBackgroundColor: '#ccff00',
        }]
    },
    options: {
        scales: {
            r: {
                angleLines: { color: '#333' },
                grid: { color: '#333' },
                pointLabels: { color: '#fff', font: { size: 12 } },
                suggestedMin: 0,
                suggestedMax: 10,
                ticks: { display: false }
            }
        },
        plugins: {
            legend: { display: false }
        }
    }
});
</script>

</body>
</html>