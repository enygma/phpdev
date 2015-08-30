<?php

require_once '../vendor/autoload.php';

// Custom autoloader
spl_autoload_register(function($class) {
    $path = __DIR__.'/../lib/'.str_replace('\\', '/', $class).'.php';
    if (is_file($path)) {
        require_once $path;
    }
});


$cache = new \Phpdev\Cache();
$id = $_SERVER['argv'][1];

if ($cache->delete($id) === true){
    echo "Cache ".$id." deleted\n";
} else {
    echo "There was an error deleting cache ".$id."\n";
}
