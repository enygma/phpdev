<?php

require_once __DIR__.'/../vendor/autoload.php';

spl_autoload_register(function($class) {
    $path = __DIR__.'/../lib/'.str_replace('\\', '/', $class).'.php';
    if (is_file($path)) {
        require_once $path;
    }
});

$cache = new \Phpdev\Cache();

$args = $_SERVER['argv'];
if (isset($args[1])) {
	echo "clearing cache for: ".$args[1]."\n";
	$cache->delete($args[1]);
}