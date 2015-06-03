<?php

$app->group('/feed', function() use ($app, $view) {

	$app->get('/', function() use ($app, $view) {
		$app->response->headers->set('Content-Type', 'text/xml');

		$cache = new \Phpdev\Cache();
		$feedData = $cache->get('feed');

		if ($feedData === null) {
			$news = new \Phpdev\Collection\News($app->di['db']);
			$news->findLatest();
			$news = $news->toArray(true);
			$cache->set('feed', $news);
		} else {
			$news = $feedData;
		}

	    echo $view->render('feed/index.php', array(
	    	'news' => $news
	    ));
	});

});