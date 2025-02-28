<?php

function generate_short_code(): string
{
    $length = rand(5, 10);
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
}

function get_expiration_date(int $days): string
{
    $today = new DateTime();
    $interval = new DateInterval("P" . abs($days) . "D");

    $days < 0 ? $today->sub($interval) : $today->add($interval);

    return $today->format("Y-m-d H:i:s");
}

function get_data()
{
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);
    if (!$data) {
        return [];
    }
    return $data;
}