<?php

date_default_timezone_set("America/Sao_Paulo");

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();