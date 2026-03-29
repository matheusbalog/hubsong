<?php
session_start();
include "config.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Termos de Uso • HubSong</title>
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

        /* Título moderno com degradê */
        h1 {
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            font-weight: 900;
            margin-bottom: 40px;
            background: linear-gradient(to right, #ffffff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
        }

        /* Blocos de conteúdo estilo HubSong */
        .terms-card {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 16px;
            border: 1px solid #1a1a1a;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .terms-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(204, 255, 0, 0.05);
        }

        h2 {
            color: var(--primary);
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 0;
            margin-bottom: 20px;
        }

        p {
            color: var(--text-dim);
            font-size: 1.05rem;
            line-height: 1.8;
            margin: 0;
        }

        .highlight {
            color: #fff;
            font-weight: 600;
        }

        .update-tag {
            margin-top: 60px;
            color: #444;
            font-size: 0.9rem;
            text-align: center;
            font-weight: 500;
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
    <h1>Termos de Uso</h1>

    <div class="terms-card">
        <p>
            Ao utilizar a <span class="highlight">HubSong</span>, você concorda integralmente com estes Termos. Se você não concorda com qualquer parte deste documento, não deverá utilizar nossos serviços.
        </p>
    </div>

    <div class="terms-card">
        <h2>1. Sobre a Plataforma</h2>
        <p>
            A <span class="highlight">HubSong</span> é um ecossistema digital focado na publicação, avaliação técnica e descoberta de novos talentos musicais de forma independente.
        </p>
    </div>

    <div class="terms-card">
        <h2>2. Gestão de Conta</h2>
        <p>
            O usuário é o único responsável pela veracidade das informações fornecidas no cadastro e pela manutenção da confidencialidade de suas credenciais de acesso.
        </p>
    </div>

    <div class="terms-card">
        <h2>3. Conduta e Conteúdo</h2>
        <p>
            Todo conteúdo (áudio, imagem e texto) é de responsabilidade exclusiva do usuário que o enviou. É proibido o upload de material que infrinja direitos autorais ou contenha discurso de ódio.
        </p>
    </div>

    <div class="terms-card">
        <h2>4. Penalidades e Moderação</h2>
        <p>
            Reservamo-nos o direito de suspender ou remover contas que violem estes termos, garantindo a integridade e a qualidade técnica da comunidade <span class="highlight">HubSong</span>.
        </p>
    </div>

    <p class="update-tag">Última atualização: <?php echo date("d/m/Y"); ?></p>
</div>

<?php include "footer.php"; ?>
</body>
</html>