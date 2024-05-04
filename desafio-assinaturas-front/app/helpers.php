<?php

function encrypt($array, $key)
{
    $serialized = serialize($array);
    $encrypted = openssl_encrypt($serialized, 'AES-256-CBC', $key, 0, substr($key, 0, 16));
    return base64_encode($encrypted);
}

function decrypt($encrypted, $key)
{
    $decrypted = openssl_decrypt(base64_decode($encrypted), 'AES-256-CBC', $key, 0, substr($key, 0, 16));
    return unserialize($decrypted);
}

function clearInputsForm($inputs)
{
    $cleaned = [];

    foreach ($inputs->data as $key => $row) {
        $cleaned['data'][$key] = htmlspecialchars($row);
    }

    $cleaned['controller'] = $inputs->controller;


    return $cleaned;
}
