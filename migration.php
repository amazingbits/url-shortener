<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/eloquent.php";

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

$tableName = "tb_url";

Capsule::schema()->dropIfExists($tableName);

Capsule::schema()->create($tableName, function (Blueprint $table) {
    $table->increments("id");
    $table->string("short_code")->unique();
    $table->text("original_url");
    $table->timestamps();
});

echo "created table: " . $tableName . "\n";