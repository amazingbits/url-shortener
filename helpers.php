<?php

function generate_short_code(): string
{
    $length = rand(5, 10);
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
}

function get_expiration_date(int $days): string
{
    $today = new DateTime();
    if ($days < 0) {
        $days = abs($days);
        $today->sub(new DateInterval("P" . $days . "D"));
    } else {
        $today->add(new DateInterval("P" . $days . "D"));
    }
    return $today->format("Y-m-d H:i:s");
}