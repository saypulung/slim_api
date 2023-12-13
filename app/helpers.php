<?php

use Ramsey\Uuid\Uuid;

function randomToken() : string
{
    $data = Uuid::uuid4();
    $cipher = "aes-256-cbc";
    $encryption_key = openssl_random_pseudo_bytes(32);
    $iv_size = openssl_cipher_iv_length($cipher); 
    $iv = openssl_random_pseudo_bytes($iv_size); 
    $encrypted_data = openssl_encrypt($data, $cipher, $encryption_key, 0, $iv);
    return $encrypted_data;
}