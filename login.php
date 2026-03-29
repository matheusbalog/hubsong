<?php
session_start();
include "config.php";

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Senha incorreta.";
        }
    } else {
        $error = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – HubSong</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap">

    <style>
        :root {
            --bg: #000000;
            --card-bg: #121212;
            --primary: #ccff00; /* Sua cor principal */
            --primary-hover: #b3e600;
            --text-main: #ffffff;
            --text-muted: #888888;
            --input-bg: #1a1a1a;
            --border: rgba(204, 255, 0, 0.1);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--bg);
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .login-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: var(--card-bg);
            padding: 40px;
            border-radius: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .login-card h2 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 8px;
            letter-spacing: -1px;
        }

        .login-card p.subtitle {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 8px;
            color: var(--primary);
            letter-spacing: 1px;
        }

        input {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid #333;
            padding: 16px;
            border-radius: 12px;
            color: white;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(204, 255, 0, 0.1);
        }

        button {
            width: 100%;
            background: var(--primary);
            color: black;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(204, 255, 0, 0.2);
        }

        .error-box {
            background: rgba(255, 50, 50, 0.1);
            color: #ff5555;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 50, 50, 0.2);
        }

        .footer-link {
            margin-top: 24px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .footer-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }

        /* Logo simulada */
        .logo-mark {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 12px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: black;
            font-size: 24px;
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="login-wrapper">
    <div class="login-card">
        <h2>Bem-vindo</h2>
        <p class="subtitle">Entre para continuar no HubSong</p>

        <?php if(isset($error)): ?>
            <div class="error-box"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" placeholder="nome@exemplo.com" required>
            </div>
            
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" name="login">Entrar na Plataforma</button>
        </form>
        <br>
        <p>OU</p><br>
<a href="google-login.php" style="text-decoration:none;">
    <button type="button" style="
        display:flex;
        align-items:center;
        justify-content:center;
        gap:10px;
        width:100%;
        background:#fff;
        color:#000;
        border:none;
        padding:12px;
        border-radius:12px;
        font-weight:600;
        cursor:pointer;
        transition:all 0.3s;
        margin-top:10px;
    ">
        <!-- Ícone oficial do Google -->
        <svg width="18" height="18" viewBox="0 0 533.5 544.3">
            <path fill="#4285F4" d="M533.5 278.4c0-17.6-1.5-34.5-4.3-51H272v96.8h146.9c-6.4 34.6-25 63.9-53.5 83.4l86.5 67.4c50.5-46.6 80.6-115 80.6-196.6z"/>
            <path fill="#34A853" d="M272 544.3c72.6 0 133.6-23.9 178.1-64.8l-86.5-67.4c-24 16-54.7 25.5-91.6 25.5-70.3 0-129.8-47.5-151-111.5l-89.5 69.2c43.3 85 131 148.9 240.5 148.9z"/>
            <path fill="#FBBC05" d="M121 327.1c-10-29.7-10-61.7 0-91.4l-89.5-69.2c-39.8 77.4-39.8 169.3 0 246.7l89.5-69.1z"/>
            <path fill="#EA4335" d="M272 107.1c37.1 0 70.5 12.8 96.7 33.3l72.3-72.3C405.4 29.1 343.7 7 272 7 162.5 7 74.8 70.9 31.5 155.9l89.5 69.2c21.2-64 80.7-111.5 151-111.5z"/>
        </svg>
        Entrar com Google
    </button>
</a>


        <div class="footer-link">
            Novo por aqui? <a href="register.php">Crie sua conta</a>
        </div>
    </div>
</div>

</body>
</html>