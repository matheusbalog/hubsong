<?php
session_start();
include "config.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre a HubSong</title>
    <style>
        :root {
            --primary: #ccff00; /* Verde Limão Neon */
            --primary-dim: rgba(204, 255, 0, 0.15);
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
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        .hero {
            height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            /* Gradiente puxando para o verde no topo */
            background: radial-gradient(circle at top center, #1a2300 0%, #000 70%);
            padding: 20px;
        }

        .hero h1 {
            font-size: clamp(3rem, 8vw, 5rem);
            font-weight: 900;
            margin: 0;
            /* Texto em degradê do branco para o verde limão */
            background: linear-gradient(to right, #fff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeIn 1.5s ease-out;
        }

        .hero p {
            font-size: 1.2rem;
            color: var(--text-dim);
            max-width: 600px;
            margin-top: 20px;
        }

        .content-section {
            max-width: 1000px;
            margin: 100px auto;
            padding: 0 20px;
        }

        .grid-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .card {
            background: var(--card-bg);
            padding: 40px;
            border-radius: 24px;
            border: 1px solid #222;
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(204, 255, 0, 0.05);
        }

        .card h3 {
            font-size: 2rem;
            margin-bottom: 15px;
            color: var(--primary);
        }

        .founders-section {
            text-align: center;
            padding: 100px 20px;
            background: #080808;
        }

        .founders-grid {
            display: flex;
            justify-content: center;
            gap: 50px;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        .founder-card {
            position: relative;
            width: 280px;
            text-align: center;
        }

        .founder-img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin-bottom: 20px;
            filter: grayscale(100%);
            transition: filter 0.5s ease, transform 0.5s ease, border-color 0.5s ease;
            border: 4px solid var(--card-bg);
            object-fit: cover;
        }

        .founder-card:hover .founder-img {
            filter: grayscale(0%);
            transform: scale(1.1) rotate(3deg);
            border-color: var(--primary);
        }

        .founder-card h4 {
            font-size: 1.5rem;
            margin: 10px 0 5px;
        }

        .founder-card span {
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.8rem;
        }

        .mission-box {
            background: linear-gradient(45deg, #121212, #1a1a1a);
            padding: 60px;
            border-radius: 30px;
            text-align: center;
            margin-top: 50px;
            position: relative;
            overflow: hidden;
            border: 1px solid #222;
        }

        .mission-box::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: 20px;
            font-size: 150px;
            color: rgba(204, 255, 0, 0.05); /* Aspas em verde limão bem suave */
            font-family: serif;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .grid-info { grid-template-columns: 1fr; }
            .hero h1 { font-size: 3rem; }
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<section class="hero">
    <h1>Avalie. Descubra. Evolua.</h1>
    <p>
        A HubSong é o ambiente onde músicas são analisadas, criticadas e lapidadas
        com base em feedback real, direto e estruturado.
    </p>
</section>

<div class="content-section">
    <div class="grid-info">
        <div class="card">
            <h3>O que é?</h3>
            <p>
                A <strong>HubSong</strong> é uma plataforma de crítica musical focada em avaliação construtiva.
                Aqui, ouvintes assumem o papel de críticos e ajudam artistas a entender,
                melhorar e validar suas músicas antes de lançamentos oficiais.
            </p>
        </div>
        <div class="card">
            <h3>Nossa Visão</h3>
            <p>
                Queremos transformar opinião em ferramenta de crescimento.
                A HubSong existe para substituir o "acho que está bom" por métricas visuais,
                criando um espaço onde a música evolui a partir de análises reais.
            </p>
        </div>
    </div>

    <div class="mission-box">
        <h2 style="color: var(--primary);">Por que existimos?</h2>
        <p style="font-size: 1.4rem; line-height: 1.6; color: #ccc;">
            Porque lançar música sem feedback é um risco desnecessário.
            A HubSong nasceu para ser o seu "grupo de teste" antes do mundo ouvir.
            Aqui, cada faixa recebe críticas honestas e métricas claras que realmente ajudam o artista a subir de nível.
        </p>
    </div>
</div>

<section class="founders-section">
    <h2 style="font-size: 2.5rem; color: #fff;">A mente por trás</h2>
    <div class="founders-grid">

        <div class="founder-card">
            <img src="img/1759153640899.jpeg" alt="Matheus Balog" class="founder-img">
            <h4>Matheus Balog</h4>
            <span>CEO</span>
            <p style="color: var(--text-dim); font-size: 0.9rem; margin-top: 10px;">
                Fundador e líder da HubSong. Estudante de Ciência da Computação
                e responsável pela visão técnica e estratégica da plataforma.
            </p>
        </div>
    </div>
</section>

<script>
    // Animação ao rolar a página
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";
            }
        });
    });

    document.querySelectorAll('.card, .founder-card, .mission-box').forEach((el) => {
        el.style.opacity = "0";
        el.style.transform = "translateY(50px)";
        el.style.transition = "all 0.8s ease-out";
        observer.observe(el);
    });
</script>

<?php include "footer.php"; ?>
</body>
</html>