<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/eloquent.php";

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

$tableUrl = "tb_url";

$tables = [
    [
        "name" => "tb_url",
        "schema" => function (Blueprint $table) {
            $table->increments("id");
            $table->string("short_code")->unique();
            $table->text("original_url");
            $table->dateTime("expiration_date");
            $table->timestamps();
        }
    ],
    [
        "name" => "tb_qrcode",
        "schema" => function (Blueprint $table) {
            $table->increments("id");
            $table->text("qrcode");
            $table->text("original_url");
            $table->timestamps();
        }
    ]
];

$tableList = [];
foreach ($tables as $table) {
    $tableList[] = $table["name"];
    Capsule::schema()->dropIfExists($table["name"]);
    Capsule::schema()->create($table["name"], $table["schema"]);
}

echo "created table(s): " . implode(", ", $tableList) . "\n";