<?php
// Simulação de sessão para teste (Remova ou comente se já houver no seu config)
$logado = isset($_SESSION['user_id']);
$role = $_SESSION['user_role'] ?? 'artist';
$avatar = $_SESSION['user_avatar'] ?? 'default.png';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
<meta name="apple-mobile-web-app-title" content="MyWebSite" />
<link rel="manifest" href="/site.webmanifest" />
<meta name="description" content="A HubSong ajuda artistas independentes a evoluírem com análises técnicas, feedbacks reais e gráficos de teia sobre mixagem, letra e composição.">
<meta name="keywords" content="música independente, produção musical, feedback de música, avaliação de faixas, gráfico de teia musical, mixagem, masterização">

<meta property="og:title" content="Sua música está pronta para o Spotify?">
<meta property="og:description" content="Receba feedbacks técnicos e visualize sua evolução na HubSong. Grátis para artistas.">
<meta property="og:image" content="https://hubsong.site/img/compartilhamento.jpg"> <meta property="og:url" content="https://hubsong.site">
<meta name="twitter:card" content="summary_large_image">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #121212;
        }

        /* TOPBAR */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            height: 64px;
            background: #000000;
            position: sticky;
            top: 0;
            z-index: 9999;
            border-bottom: 1px solid #282828;
        }

        .topbar-left, .topbar-right {
            display: flex;
            align-items: center;
        }

        .topbar-left { gap: 30px; }
        .topbar-right { gap: 20px; }

        /* LOGO */
        .logo img {
            height: 45px;
            display: block;
        }

        /* SISTEMA DE DROPDOWN */
        .dropdown-container {
            position: relative;
            padding: 10px 0;
        }

        .menu-btn, .account-trigger {
            background: none;
            border: none;
            color: #b3b3b3;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .menu-btn:hover, .account-trigger:hover {
            color: #fff;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            background: #282828;
            min-width: 180px;
            border-radius: 4px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            padding: 5px;
            z-index: 10000;
        }

        .dropdown-left { left: 0; }
        .dropdown-right { right: 0; }

        .dropdown-container:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: #e0e0e0;
            padding: 12px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            border-radius: 2px;
        }

        .dropdown-content a:hover {
            background: #3e3e3e;
            color: #fff;
        }

        /* BOTÕES */
        .btn-link {
            text-decoration: none;
            color: #b3b3b3;
            font-weight: 700;
            font-size: 14px;
        }

        .btn-white {
            background: #fff;
            color: black;
            padding: 8px 20px;
            border-radius: 500px;
            text-decoration: none;
            font-weight: 700;
            transition: 0.2s;
            font-size: 14px;
        }

        .btn-white:hover { transform: scale(1.05); }

        /* AVATAR */
        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #333;
        }

        /* RESPONSIVIDADE (CORREÇÃO MOBILE) */
        @media (max-width: 768px) {
            .topbar { padding: 0 10px; }
            .topbar-left { gap: 15px; }
            .topbar-right { gap: 12px; }

            /* Removemos o .btn-artist daqui para ele aparecer */
            .menu-btn span, .account-trigger span {
                display: none; 
            }

            /* Ajuste opcional para o link do artista no mobile */
            .btn-artist {
                font-size: 12px;
                color: #fff; /* Destaque para facilitar o clique */
            }

            /* Se o texto "Minhas músicas" for grande demais para o seu celular, 
               o código abaixo troca para apenas "Músicas" via CSS (opcional) */
            /* .btn-artist::after { content: "Músicas"; }
            .btn-artist { font-size: 0; } 
            */
        }
    </style>
</head>
<body>

<header class="topbar">
    <div class="topbar-left">
        <a href="https://hubsong.site/" class="logo">
            <img src="img/logo_preto_1.png" alt="TuneTest">
        </a>

        <div class="dropdown-container">
            <!--<button class="menu-btn"><span>Gêneros</span> ▾</button>-->
            <div class="dropdown-content dropdown-left">
                <!--<a href="#">Pop</a>-->
                <!--<a href="#">Rock</a>-->
                <!--<a href="#">Sertanejo</a>-->
                <!--<a href="#">Eletrônica</a>-->
            </div>
        </div>
    </div>

    <div class="topbar-right">
        <?php if (!$logado): ?>
    <a href="register.php" class="btn-link">Criar Conta</a>
    <a href="login.php" class="btn-white">Entrar</a>
<?php else: ?>
    <?php if ($role === 'artist'): ?>
        <a href="minhas_musicas.php" class="btn-link btn-artist">Minhas músicas</a>
    <?php endif; ?>

    <div class="dropdown-container">
        <div class="account-trigger">
            <span><?php echo htmlspecialchars($user_name); ?></span>
            <img src="avatars/<?php echo htmlspecialchars($avatar); ?>" class="avatar">
        </div>
        <div class="dropdown-content dropdown-right">
            <a href="logout.php">Sair</a>
        </div>
    </div>
<?php endif; ?>

    </div>
</header>

<link rel="manifest" href="/manifest.json">

<script>
if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker.register("/service-worker.js")
      .then(reg => { console.log("Service Worker registrado:", reg.scope); })
      .catch(err => { console.error("Falha ao registrar SW:", err); });
  });
}
</script>

</body>
</html>