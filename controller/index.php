<?php

use \Psecio\Gatekeeper\Gatekeeper as g;

$app->group('/', function() use ($app, $view) {

	function renderNews($news, $view)
	{
		$newsRendered = '';
		$itemView = new \Phpdev\View\NewsItemView();
		foreach ($news as $item) {
			$newsRendered .= $itemView->render('news/_item.php', array(
				'news' => $item,
				'tags' => $item->tags->toArray(true)
			));
		}

	    return $view->render('index/index.php', array(
	    	'news' => $newsRendered
	    ));
	}

	$app->get('/', function() use ($app, $view) {
		$newsLatest = $app->di['cache']->get('news:latest');

		if ($newsLatest === null) {
			$news = new \Phpdev\Collection\News($app->di['db']);
			$news->findLatest();
			$app->di['cache']->set('news:latest', $news);
			$newsLatest = renderNews($news, $view);

			$app->di['cache']->set('news:latest', $newsLatest);
		}

		echo $newsLatest;
	});
});

$app->get('/tutorials', function () use ($app, $view) {
	$news = new \Phpdev\Collection\News($app->di['db']);
	$news->findByTag('tutorial');

	echo renderNews($news, $view);
});
$app->get('/book', function () use ($app, $view) {
	$news = new \Phpdev\Collection\News($app->di['db']);
	$news->findByTag('book');

	echo renderNews($news, $view);
});
$app->get('/events', function () use ($app, $view) {
	$news = new \Phpdev\Collection\News($app->di['db']);
	$news->findByTag('conference');

	echo renderNews($news, $view);
});
$app->get('/contact', function() use ($app, $view) {
	echo $view->render('index/contact.php');
});

$app->get('/archive(/:pageId)', function($pageId = 1) use ($app, $view) {

	$newsItems = array();
	$news = new \Phpdev\Collection\News($app->di['db']);
	$news->findLatest(100);

	$news = $news->toArray(true);
	// Break them up into days
	foreach ($news as $item) {
		$day = date('m.d.Y (l)', $item['date']);
		if (array_key_exists($day, $newsItems) === true) {
			$newsItems[$day][] = $item;
		} else {
			$newsItems[$day] = array($item);
		}
	}

	echo $view->render('index/archive.php', array(
		'news' => $newsItems
	));
});

$app->get('/error', function() use ($app, $view) {
	// print_r($_SESSION); echo "<br/><br/>";
	// var_export($app->flashData());
	$message = $app->di['session']->getSegment('default')->getFlash('error');
	$view->render(
		'error/error.php',
		array('message' => $message)
	);
});
