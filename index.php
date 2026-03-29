<?php
session_start();
include "config.php";

// Verifica se o usuário está logado
$user_logged = false;
if (isset($_SESSION['user_id'])) {
    $user_logged = true;
    $user_name = $_SESSION['user_name'];
}

// Busca músicas
$query = "
SELECT
  songs.id,
  songs.title,
  users.name AS artist_name,
  users.avatar
FROM songs
JOIN users ON songs.artist_id = users.id
ORDER BY songs.uploaded_at DESC
";

$result = $conn->query($query);

$songs = [];
while($row = $result->fetch_assoc()){
  $songs[] = $row;
}

// Agrupa músicas de 10 em 10
$groups = !empty($songs) ? array_chunk($songs, 10) : [];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HubSong – Feedback Musical</title>

<style>
:root {
  --bg: #0a0a0a;
  --card: #181818;
  --card-hover: #222;
  --text: #ffffff;
  --muted: #b3b3b3;
  --primary: #ccff00;
}

* { box-sizing: border-box; }

body {
  margin: 0;
  background: var(--bg);
  color: var(--text);
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  overflow-x: hidden;
}

.hero {
  padding: 60px 20px;
  text-align: center;
  background: radial-gradient(circle at center, #1a2300 0%, #0a0a0a 100%);
  border-bottom: 1px solid #1a1a1a;
}

.hero h1 { font-size: clamp(2.5rem, 8vw, 4rem); margin: 0; line-height: 1.1; letter-spacing: -2px; }
.hero span { color: var(--primary); }
.hero p { color: var(--muted); font-size: 1.1rem; max-width: 600px; margin: 20px auto 30px; }

.cta-buttons { display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; }
.btn { padding: 14px 28px; border-radius: 50px; text-decoration: none; font-weight: 700; transition: 0.3s; }
.btn-primary { background: var(--primary); color: #000; }
.btn-primary:hover { transform: scale(1.05); background: #b3e600; }
.btn-outline { border: 1px solid #333; color: #fff; }
.btn-outline:hover { background: #1a1a1a; border-color: #555; }

.container { max-width: 1400px; margin: 0 auto; padding: 40px 20px; }
.carousel-title { font-size: 22px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.carousel-title::before { content: ''; width: 4px; height: 24px; background: var(--primary); display: inline-block; border-radius: 2px; }
.carousel-wrapper { position: relative; }
.feed { display: flex; gap: 20px; overflow-x: auto; scroll-behavior: smooth; padding-bottom: 20px; scrollbar-width: none; }
.feed::-webkit-scrollbar { display: none; }
.song { background: var(--card); border-radius: 12px; padding: 16px; text-decoration: none; color: var(--text); transition: all 0.3s ease; flex: 0 0 200px; display: flex; flex-direction: column; }
.song:hover { background: var(--card-hover); transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
.song-cover-wrapper { position: relative; width: 100%; aspect-ratio: 1/1; margin-bottom: 12px; }
.song-cover { width: 100%; height: 100%; background: linear-gradient(135deg, #222, #111); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 40px; color: var(--primary); box-shadow: 0 8px 15px rgba(0,0,0,0.3); }
.song-action { position: absolute; right: 10px; bottom: 10px; width: 45px; height: 45px; background: var(--primary); color: #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800; opacity: 0; transform: scale(0.8); transition: 0.3s; }
.song:hover .song-action { opacity: 1; transform: scale(1); }
.song-title { font-size: 15px; font-weight: 700; margin: 0 0 5px 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.song-artist { font-size: 13px; color: var(--muted); display: flex; align-items: center; gap: 8px; }
.song-artist img { width: 20px; height: 20px; border-radius: 50%; object-fit: cover; background: #333; }
.arrow { background: rgba(0,0,0,0.8); color: var(--primary); border: 1px solid #333; width: 40px; height: 40px; border-radius: 50%; position: absolute; top: 50%; transform: translateY(-50%); cursor: pointer; z-index: 10; font-size: 20px; display: none; }
@media (min-width: 1024px) { .arrow { display: block; } }
.arrow.left { left: -20px; }
.arrow.right { right: -20px; }

.header-login { position: absolute; top: 20px; right: 20px; }
.header-login a { color: var(--primary); font-weight: 700; text-decoration: none; padding: 8px 12px; border: 1px solid var(--primary); border-radius: 8px; transition: 0.3s; }
.header-login a:hover { background: var(--primary); color: #000; }
</style>
</head>

<body>

<?php include "header.php"; ?>

<!-- Botão de login ou saudação -->


<section class="hero">
    <h1>Evolua sua <span>Música</span></h1>
    <p>A primeira plataforma de feedback técnico para artistas independentes. Receba notas reais e melhore suas tracks.</p>
    <div class="cta-buttons">
        <?php if($user_logged): ?>
          <a href="upload.php" class="btn btn-primary">ENVIAR MINHA MÚSICA</a>
        <?php else: ?>
          <a href="register.php" class="btn btn-primary">CRIAR CONTA</a>
        <?php endif; ?>
        <a href="#feed" class="btn btn-outline">AVALIAR TRACKS</a>
    </div>
</section>

<div class="container" id="feed">
  
  <?php if(empty($groups)): ?>
    <div style="text-align:center; padding: 50px; color: var(--muted);">
        <h3>O feed está sendo preparado...</h3>
        <p>Seja o primeiro a enviar uma música hoje!</p>
        <?php if($user_logged): ?>
          <a href="upload.php" class="btn btn-primary">Começar agora</a>
        <?php else: ?>
          <a href="register.php" class="btn btn-primary">Começar agora</a>
        <?php endif; ?>
    </div>
  <?php else: ?>
    
    <?php foreach($groups as $index => $group): ?>
      <div class="carousel">
        <div class="carousel-title">Novas para avaliar #<?php echo $index + 1; ?></div>

        <div class="carousel-wrapper">
          <button class="arrow left" onclick="scrollFeed(<?php echo $index; ?>, -1)">‹</button>

          <div class="feed" id="feed-<?php echo $index; ?>">
            <?php foreach($group as $song): ?>
              <a class="song" href="song.php?id=<?php echo $song['id']; ?>">
                <div class="song-cover-wrapper">
                  <div class="song-cover">H</div>
                  <div class="song-action">NOTAS</div>
                </div>
                <div class="song-title"><?php echo htmlspecialchars($song['title']); ?></div>
                <div class="song-artist">
                  <img src="avatars/<?php echo htmlspecialchars($song['avatar'] ?? 'default.png'); ?>">
                  <span><?php echo htmlspecialchars($song['artist_name']); ?></span>
                </div>
              </a>
            <?php endforeach; ?>
          </div>

          <button class="arrow right" onclick="scrollFeed(<?php echo $index; ?>, 1)">›</button>
        </div>
      </div>
    <?php endforeach; ?>

  <?php endif; ?>

</div>

<?php include "footer.php"; ?>

<script>
function scrollFeed(index, direction){
  const feed = document.getElementById('feed-' + index);
  if (!feed) return;
  const scrollAmount = feed.clientWidth * 0.8;
  feed.scrollLeft += direction * scrollAmount;
}
</script>

</body>
</html>
