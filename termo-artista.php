<?php
session_start();
include "config.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Aviso Legal para Artistas • HubSong</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --primary: #ccff00; /* Verde Limão Neon */
            --bg-dark: #000000;
            --card-bg: #121212;
            --text-main: #ffffff;
            --text-dim: #a7a7a7;
        }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 100px auto;
            padding: 0 24px;
        }

        /* Título com degradê para o verde limão */
        h1 {
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            font-weight: 900;
            margin-bottom: 40px;
            background: linear-gradient(to right, #ffffff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
        }

        /* Seções estilizadas como cards sutis */
        .term-section {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 16px;
            border: 1px solid #1a1a1a;
            margin-bottom: 25px;
            transition: border-color 0.3s ease;
        }

        .term-section:hover {
            border-color: var(--primary);
        }

        h2 {
            color: var(--primary);
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 0;
            margin-bottom: 15px;
        }

        p {
            color: var(--text-dim);
            font-size: 1.1rem;
            margin: 0;
        }

        .highlight {
            color: #fff;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .container { margin: 60px auto; }
            h1 { font-size: 2.5rem; }
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="container">
    <h1>Aviso Legal para Artistas</h1>

    <div class="term-section">
        <h2>Propriedade Intelectual</h2>
        <p>
            Ao enviar músicas para a <span class="highlight">HubSong</span>, o artista declara e garante que possui todos os direitos autorais, fonográficos e de propriedade intelectual sobre o conteúdo enviado.
        </p>
    </div>

    <div class="term-section">
        <h2>Licença de Uso</h2>
        <p>
            O artista concede à <span class="highlight">HubSong</span> uma licença gratuita, não exclusiva e mundial para hospedar, processar dados de áudio, reproduzir e exibir o conteúdo estritamente dentro das funcionalidades da plataforma.
        </p>
    </div>

    <div class="term-section">
        <h2>Responsabilidade Civil</h2>
        <p>
            O usuário artista é o único e integral responsável por eventuais violações de direitos de terceiros (samples não autorizados, plágio ou uso indevido de imagem). A <span class="highlight">HubSong</span> atua apenas como plataforma de tecnologia.
        </p>
    </div>

    <div class="term-section">
        <h2>Remoção e Moderação</h2>
        <p>
            O conteúdo poderá ser removido a qualquer momento mediante solicitação do titular ou em caso de denúncia fundamentada de violação de termos de uso ou direitos autorais.
        </p>
    </div>
</div>

<?php include "footer.php"; ?>
</body>
</html>