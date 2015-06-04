<?php
use Pimple\Container;

// Custom autoloader
spl_autoload_register(function($class) {
    $path = __DIR__.'/lib/'.str_replace('\\', '/', $class).'.php';
    if (is_file($path)) {
        require_once $path;
    }
});

session_start();

\Psecio\Gatekeeper\Gatekeeper::init('../');

$app = new \Slim\Slim();
$app->config(array(
	'view' => new \Phpdev\View\TemplateView(),
	'templates.path' => '../templates',
	'debug' => true
));
$app->contentType('text/html; charset=utf-8');

$view = $app->view();
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);
$view->parserOptions = array(
    'debug' => true
);

$app->error(function (\Exception $e) use ($app, $view) {
    $view->render('error/error.php', array('message' => $e->getMessage()));
});

// Make the database instance
$di = new Container();
$di['db'] = function()
{
	$dsn = 'mysql:host=127.0.0.1;dbname=phpdev;charset=UTF8';
    return new \PDO($dsn, 'phpdev', 'phpdev42');
};

// Make the session instance
$di['session'] = function()
{
    $data = array();
    $sessionFactory = new \Aura\Session\SessionFactory;
    return $sessionFactory->newInstance($data);
};

$di['user'] = function($di)
{
    $user = $di['session']->getSegment('default')->get('user');
    if ($user !== null) {
        try {
            $user = \Psecio\Gatekeeper\Gatekeeper::findUserById($user['id']);
        } catch (\Exception $e) {
            // do nothing for now...
        }

    }
    return $user;
};

$app->di = $di;
$view->di = $di;
