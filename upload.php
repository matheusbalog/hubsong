<?php
session_start();
include "config.php";

// Só artistas podem enviar música
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'artist') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['upload'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $artist_id = $_SESSION['user_id'];

    if (isset($_FILES['music']) && $_FILES['music']['error'] === 0) {

        $file = $_FILES['music'];
        $allowed = ['mp3', 'wav', 'ogg'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {

            $newName = uniqid("song_") . "." . $ext;
            $uploadPath = "uploads/" . $newName;

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {

                $stmt = $conn->prepare("
                    INSERT INTO songs (artist_id, title, filename, description)
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->bind_param("isss", $artist_id, $title, $newName, $description);

                if ($stmt->execute()) {
                    $success = "Música enviada com sucesso!";
                } else {
                    $error = "Erro ao salvar no banco.";
                }

            } else {
                $error = "Erro ao mover o arquivo.";
            }

        } else {
            $error = "Formato inválido. Use mp3, wav ou ogg.";
        }

    } else {
        $error = "Nenhum arquivo enviado.";
    }
}
?>

<?php include "header.php"; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Upload de Música – TuneTest</title>

<style>
:root{
    --roxo:#ccff00;
    --azul:#ccff00;
    --preto:#000;
    --card:#151515;
    --borda:rgba(255,255,255,.15);
}

html, body{
    margin:0;
    padding:0;
    width:100%;
    height:100%;
    background:var(--preto);
    font-family:Inter, Arial, sans-serif;
    color:#fff;
}

.upload-container{
    min-height:calc(100vh - 80px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}

.upload-card{
    width:100%;
    max-width:460px;
    background:var(--card);
    border:1px solid var(--borda);
    border-radius:18px;
    padding:28px;
    color: black;
}

.upload-card h2{
    margin:0 0 20px;
    font-size:22px;
    text-align:center;
    color: black;
}

.upload-card form{
    display:flex;
    flex-direction:column;
    gap:14px;
}

.upload-card input[type="text"],
.upload-card textarea{
    background:#0e0e0e;
    border:1px solid var(--borda);
    border-radius:10px;
    padding:12px 14px;
    color:#fff;
    font-size:14px;
}

.upload-card textarea{
    resize:vertical;
    min-height:80px;
}

.upload-card input:focus,
.upload-card textarea:focus{
    outline:none;
    border-color:var(--roxo);
}

.upload-card input[type="file"]{
    font-size:13px;
    color:#ccc;
}

.upload-card button{
    margin-top:10px;
    padding:12px;
    border:none;
    border-radius:10px;
    background:var(--roxo);
    color:#fff;
    font-size:15px;
    cursor:pointer;
    transition:.25s;
}

.upload-card button:hover{
    background:var(--azul);
}

.message{
    padding:10px;
    border-radius:10px;
    font-size:13px;
    text-align:center;
}

.error{
    background:rgba(255,80,80,.1);
    border:1px solid rgba(255,80,80,.4);
    color:#ff8080;
}

.success{
    background:rgba(80,200,120,.1);
    border:1px solid rgba(80,200,120,.4);
    color:#7dffb0;
}

.upload-footer{
    text-align:center;
    margin-top:16px;
    font-size:13px;
}

.upload-footer a{
    color:var(--azul);
    text-decoration:none;
}

.upload-footer a:hover{
    text-decoration:underline;
}
</style>
</head>

<body>

<div class="upload-container">
    <div class="upload-card">

        <h2>Enviar música</h2>

        <?php if (isset($error)): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="message success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Título da música" required>
            <textarea name="description" placeholder="Descrição (opcional)"></textarea>
            <input type="file" name="music" accept=".mp3,.wav,.ogg" required>
            <button type="submit" name="upload">Enviar música</button>
        </form>

        <div class="upload-footer">
            <a href="index.php">← Voltar ao feed</a>
        </div>

    </div>
</div>

</body>
</html>
<?php include "footer.php"; ?>