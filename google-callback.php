<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
include "config.php"; // Conexão $conn

// Configurações do Google Client
$client = new Google_Client();
$client->setClientId("60469187168-4oh4sa5ra5dodlbe9br85oh95vqbvk6i.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("https://hubsong.site/google-callback.php");
$client->addScope("email");
$client->addScope("profile");

// Checa se o código de autorização existe
if (!isset($_GET['code'])) {
    die("Código de autorização não encontrado.");
}

// Troca código por token
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
if (isset($token['error'])) {
    die("Erro ao obter token: " . $token['error']);
}

$client->setAccessToken($token);

// Pega informações do usuário
$oauth = new Google_Service_Oauth2($client);
$userInfo = $oauth->userinfo->get();

$email = $userInfo->email;
$name  = $userInfo->name;
$googleId = $userInfo->id;
$avatarUrl = $userInfo->picture;

// Define role padrão como artist
$role = "artist";

// Habilita erros mysqli para debug
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Verifica se usuário já existe pelo email
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Usuário já existe
    $user = $result->fetch_assoc();
    $_SESSION['user_id'] = $user['id'];
} else {
    // Novo usuário → baixa avatar
    $avatarName = uniqid("avatar_") . ".jpg";
    $avatarPath = __DIR__ . "/avatars/" . $avatarName;

    // Baixa a imagem do Google e salva localmente
    $avatarContent = @file_get_contents($avatarUrl);
    if ($avatarContent) {
        file_put_contents($avatarPath, $avatarContent);
    } else {
        // Se não conseguiu baixar, usa avatar default
        $avatarName = "default.png";
    }

    $provider = "google";

    // Insere no banco
    $stmt = $conn->prepare(
        "INSERT INTO users (name, email, google_id, provider, avatar, role)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("ssssss", $name, $email, $googleId, $provider, $avatarName, $role);
    $stmt->execute();

    $_SESSION['user_id'] = $stmt->insert_id;
}

// Pega a role do banco e salva na sessão
$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$_SESSION['role'] = $user['role'];

// Redireciona para dashboard ou home
header("Location: index.php");
exit;
