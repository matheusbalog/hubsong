<?php
session_start();
include "config.php";

$logado = isset($_SESSION['user_id']);
$user_name = $_SESSION['user_name'] ?? '';
$user_avatar = $_SESSION['user_avatar'] ?? 'default.png';

$query = "
SELECT 
    users.id AS artist_id,
    users.name AS artist_name,
    users.avatar,
    songs.id AS song_id,
    songs.title
FROM users
JOIN songs ON songs.artist_id = users.id
ORDER BY songs.uploaded_at DESC
";

$result = $conn->query($query);
$artists = [];

while ($row = $result->fetch_assoc()) {
    $artists[$row['artist_id']]['name'] = $row['artist_name'];
    $artists[$row['artist_id']]['avatar'] = $row['avatar'] ?? 'default.png';
    $artists[$row['artist_id']]['songs'][] = [
        'id' => $row['song_id'],
        'title' => $row['title']
    ];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>TuneTest – Feed</title>
<link rel="stylesheet" href="style.css">
<style>
:root{
  --roxo:#7845bf;
  --laranja:#f66e4c;
  --azul:#4185e0;
  --preto:#000000;
  --cinza-escuro:#111111;
  --card:#151515;
}

html, body{
  margin:0;
  padding:0;
  width:100%;
  min-height:100%;
  font-family: Inter, Arial, sans-serif;
  background:#000000;
  color:#ffffff;
}

.container{
  max-width:1100px;
  margin:40px auto;
  padding:0 20px;
  background:transparent;
}

h1{
  font-size:28px;
  margin-bottom:30px;
}

.feed{
  display:flex;
  flex-direction:column;
  gap:30px;
}

.artist{
  background:var(--card);
  border-radius:18px;
  padding:20px;
  box-shadow:0 0 0 1px #1f1f1f;
}

.artist-header{
  display:flex;
  align-items:center;
  gap:15px;
  margin-bottom:15px;
}

.artist-header img{
  width:60px;
  height:60px;
  border-radius:50%;
  object-fit:cover;
  border:2px solid var(--roxo);
}

.artist-header strong{
  font-size:18px;
}

.song-list{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
  gap:15px;
}

.song{
  background:var(--cinza-escuro);
  padding:15px;
  border-radius:14px;
  text-decoration:none;
  color:#fff;
  border-left:4px solid var(--roxo);
  transition:.25s ease;
}

.song:hover{
  background:#1c1c1c;
  border-left-color:var(--azul);
  transform:translateY(-2px);
}

.song:hover{
  transform:translateY(-4px) scale(1.02);
  box-shadow:0 10px 25px rgba(0,0,0,.5);
}

.song span{
  font-size:14px;
  opacity:.9;
}

@media(max-width:600px){
  h1{font-size:22px}
  .artist-header img{width:50px;height:50px}
}
</style>
</head>
<body>

<?php include "header.php"; ?>

<div class="container">
  <h1>Descubra novas músicas</h1>

  <div class="feed">
    <?php foreach ($artists as $artist): ?>
      <div class="artist">
        <div class="artist-header">
          <img src="avatars/<?php echo htmlspecialchars($artist['avatar']); ?>">
          <strong><?php echo htmlspecialchars($artist['name']); ?></strong>
        </div>

        <div class="song-list">
          <?php foreach ($artist['songs'] as $song): ?>
            <a class="song" href="song.php?id=<?php echo $song['id']; ?>">
              <span>🎵 <?php echo htmlspecialchars($song['title']); ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>
