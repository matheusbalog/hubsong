<?php

if (file_exists(__DIR__ . '/config.local.php')) {
    require __DIR__ . '/config.local.php';
} else {

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "hubsong_db";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

}
?>