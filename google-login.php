<?php
require __DIR__ . '/vendor/autoload.php';

$client = new Google_Client();

$client->setClientId("60469187168-4oh4sa5ra5dodlbe9br85oh95vqbvk6i.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("https://hubsong.site/google-callback.php");

$client->addScope("email");
$client->addScope("profile");

header("Location: " . $client->createAuthUrl());
exit;
