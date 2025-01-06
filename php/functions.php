<?php
function getRandomString(int $len): string {
    $chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $max = strlen($chars)-1;
    mt_srand();
    $random = '';
    for ($i = 0; $i < $len; $i++)
        $random .= $chars[mt_rand(0, $max)];
    return $random;
}
?>
