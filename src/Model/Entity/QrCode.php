<?php

namespace Src\Model\Entity;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $table = "tb_qrcode";

    protected $fillable = ["qrcode", "original_url"];
}