<?php
date_default_timezone_set('America/Sao_Paulo');

error_reporting(E_ERROR | E_PARSE);

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable("/var/www/html")->load();

require_once __DIR__ . "/../app/helpers.php";

require_once __DIR__ . "/../app/Routes/HttpClient.php";

require_once __DIR__ . "/../app/Core/Cadastros.php";

require_once __DIR__ . "/../app/Core/Assinaturas.php";

require_once __DIR__ . "/../app/Core/Faturas.php";

require_once __DIR__ . "/../app/Core/User.php";

require_once __DIR__ . "/../app/Core/Session.php";

require_once __DIR__ . "/../app/Core/Customs.php";
$session = new Session();
