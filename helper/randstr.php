<?php
function random_string($length = 8) {
    $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charsetLen = strlen($charset);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $r .= $charset[rand(0, $charsetLen - 1)];
    }
    return $r;
}
?>