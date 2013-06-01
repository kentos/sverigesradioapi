<?php
function cache_get_contents($url, $force = false) {
    $hash = md5($url);
    $cache_dir = dirname(__FILE__) . '/../cache/';
    $cache_file = $cache_dir . $hash . '.cache';

    if (is_file($cache_file) && !$force) {
        return file_get_contents($cache_file);
    }

    $data = file_get_contents($url);
    file_put_contents($cache_file, $data);

    return $data;
}