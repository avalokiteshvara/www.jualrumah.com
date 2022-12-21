<?php

function generateRandomString($length = 20) {
    $seed = '0123456789'.
        'abcdefghijklmnopqrstuvwxyz'.
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    //shuffle($seed);
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $seed[rand(0, strlen($seed) - 1)];
    }
    return $randomString;
}