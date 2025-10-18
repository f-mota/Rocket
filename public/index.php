<?php

$uri = $_SERVER['REQUEST_URI'];

if ($uri !== '/adminer.php' && !str_starts_with($uri, '/adminer')) {
    require_once __DIR__ . '/../index.php';
}

?>
