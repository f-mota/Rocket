
<?php

$uri = $_SERVER['REQUEST_URI'];

if ($uri === '/adminer.php') {
    return; // no redirige, permite que adminer.php se ejecute directamente
}

require_once __DIR__ . '/../index.php';

?>
