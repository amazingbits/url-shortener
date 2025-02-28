<?php

namespace Src\Model\Entity;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $table = "tb_url";

    protected $fillable = ["short_code", "original_url"];
}