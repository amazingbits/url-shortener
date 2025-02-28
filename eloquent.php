<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$capsule = new Capsule();

$databaseName = getenv("DATABASE_NAME") ?: "db.sqlite";
$databaseDir = __DIR__ . "/" . $databaseName;
$connectionConfig = [
    "driver" => "sqlite",
    "database" => $databaseDir
];

$capsule->addConnection($connectionConfig);

$capsule->setAsGlobal();
$capsule->bootEloquent();

if (!file_exists($databaseDir)) {
    touch($databaseDir);
}