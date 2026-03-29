<?php
session_start();
include "config.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Política de Privacidade • HubSong</title>
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

        /* Título com degradê moderno */
        h1 {
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            font-weight: 900;
            margin-bottom: 40px;
            background: linear-gradient(to right, #ffffff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
        }

        /* Seções estilizadas como blocos de conteúdo */
        .policy-section {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 16px;
            border: 1px solid #1a1a1a;
            margin-bottom: 25px;
            transition: border-color 0.3s ease;
        }

        .policy-section:hover {
            border-color: var(--primary);
        }

        h2 {
            color: var(--primary);
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 0;
            margin-bottom: 20px;
        }

        p, li {
            color: var(--text-dim);
            font-size: 1.05rem;
            line-height: 1.8;
        }

        ul {
            padding-left: 20px;
            list-style: none;
        }

        ul li::before {
            content: "→";
            color: var(--primary);
            font-weight: bold;
            display: inline-block; 
            width: 1em;
            margin-left: -1em;
        }

        .highlight {
            color: #fff;
            font-weight: 600;
        }

        .footer-date {
            margin-top: 60px;
            color: #444;
            font-size: 0.9rem;
            text-align: center;
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
    <h1>Política de Privacidade</h1>

    <div class="policy-section">
        <p>
            A <span class="highlight">HubSong</span> respeita a sua privacidade e está comprometida com a proteção de dados pessoais, operando em total conformidade com a Lei Geral de Proteção de Dados (LGPD).
        </p>
    </div>

    <div class="policy-section">
        <h2>1. Dados Coletados</h2>
        <ul>
            <li>Nome de usuário e E-mail</li>
            <li>Senha (criptografada via hash seguro)</li>
            <li>Tipo de conta (ouvinte ou artista)</li>
            <li>Arquivos de áudio, capas e metadados enviados</li>
            <li>Logs técnicos (IP, navegador e registros de acesso)</li>
        </ul>
    </div>

    <div class="policy-section">
        <h2>2. Finalidade do Tratamento</h2>
        <p>
            Os dados são coletados exclusivamente para o funcionamento da plataforma, autenticação de segurança, geração dos <span class="highlight">gráficos de teia</span> e melhoria contínua da experiência do usuário.
        </p>
    </div>

    <div class="policy-section">
        <h2>3. Compartilhamento de Dados</h2>
        <p>
            A <span class="highlight">HubSong</span> não comercializa dados pessoais. O compartilhamento ocorre apenas com provedores de infraestrutura técnica (como hospedagem) ou por estrita exigência legal.
        </p>
    </div>

    <div class="policy-section">
        <h2>4. Seus Direitos</h2>
        <p>
            Você possui total controle sobre seus dados. A qualquer momento, através das configurações ou suporte, você pode solicitar o acesso, a correção ou a <span class="highlight">exclusão definitiva</span> de suas informações da nossa base.
        </p>
    </div>

    <p class="footer-date">Última atualização: <?php echo date("d/m/Y"); ?></p>
</div>

<?php include "footer.php"; ?>
</body>
</html>