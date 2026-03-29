<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "config.php"; // Conexão $conn

// Cadastro padrão: só artista
if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = "artist"; // todo usuário é artista

    $avatar = "default.png";

    if (!empty($_FILES['avatar']['name'])) {
        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {
            $avatar = uniqid("avatar_") . "." . $ext;
            $target = "avatars/" . $avatar;

            if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
                $avatar = "default.png";
            }
        }
    }

    $stmt = $conn->prepare(
        "INSERT INTO users (name, email, password, role, avatar)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssss", $name, $email, $password, $role, $avatar);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Erro ao cadastrar. O e-mail pode já estar em uso.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta – HubSong</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap">

    <style>
        :root {
            --bg: #000000;
            --card-bg: #121212;
            --primary: #ccff00; 
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

        .register-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .register-card {
            width: 100%;
            max-width: 450px;
            background: var(--card-bg);
            padding: 40px;
            border-radius: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .register-card h2 {
            font-size: 32px;
            font-weight: 800;
            margin: 0 0 8px 0;
            letter-spacing: -1px;
            text-align: center;
        }

        .register-card p.subtitle {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 32px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 8px;
            color: var(--primary);
            letter-spacing: 1px;
        }

        input {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid #333;
            padding: 14px;
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

        input[type="file"] {
            padding: 10px;
            font-size: 13px;
            cursor: pointer;
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
            text-align: center;
        }

        .footer-link {
            margin-top: 24px;
            font-size: 14px;
            color: var(--text-muted);
            text-align: center;
        }

        .footer-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }

        .google-btn {
            display: block;
            margin: 20px auto 0;
            background: #4285F4;
            color: #fff;
            text-align: center;
            padding: 14px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
        }

        .google-btn:hover {
            background: #357ae8;
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="register-wrapper">
    <div class="register-card">
        <h2>Criar conta</h2>
        <p class="subtitle">Junte-se à comunidade HubSong</p>

        <?php if(isset($error)): ?>
            <div class="error-box"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" placeholder="Como quer ser chamado?" required>
            </div>

            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" placeholder="seu@email.com" required>
            </div>
            
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="form-group">
                <label>Foto de Perfil</label>
                <input type="file" name="avatar" accept="image/*">
            </div>

            <button type="submit" name="register">Finalizar Cadastro</button>
        </form>

        <!-- Botão de cadastro/login com Google -->
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
        Criar Conta com Google
    </button>
</a>


        <div class="footer-link">
            Já possui uma conta? <a href="login.php">Fazer Login</a>
        </div>
    </div>
</div>

</body>
</html>
