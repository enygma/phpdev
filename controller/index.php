<?php

use \Psecio\Gatekeeper\Gatekeeper as g;

$app->group('/', function() use ($app, $view) {

	function renderNews($news, $view, $app)
	{
		$newsRendered = '';
        $newsRendered = $app->di['cache']->get('news:latest:index');

        if ($newsRendered === null) {
		    $itemView = new \Phpdev\View\NewsItemView();
		    foreach ($news as $item) {
			    $newsRendered .= $itemView->render('news/_item.php', array(
				    'news' => $item,
			    	'tags' => $item->tags->toArray(true)
			    ));
		    }
            $app->di['cache']->set('news:latest:index', $newsRendered);
        }

	    return $view->render('index/index.php', array(
	    	'news' => $newsRendered
	    ));
	}

	$app->get('/', function() use ($app, $view) {
			$news = new \Phpdev\Collection\News($app->di['db']);
			$news->findLatest();
			$app->di['cache']->set('news:latest', $news);
			$newsLatest = renderNews($news, $view, $app);

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

$app->get('/archive(/:pageId)', function($pageId = 0) use ($app, $view) {

	$newsItems = array();
	$news = new \Phpdev\Collection\News($app->di['db']);
	// $news->findLatest(100);

	// Our page # corresponds to a week, 0 being this week
	if ($pageId == 0) {
		$end = time();
		$start = strtotime('-1 week');
	} else {
		$end = strtotime('-'.$pageId.' week');
		$start = strtotime('-'.($pageId + 1).' week');
	}
	$news->findDateRange($start, $end);

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

	$data = [
		'news' => $newsItems,
		'pageId' => $pageId,
		'nextPage' => ($pageId + 1),
		'prevPage' => 0
	];
	if (($pageId - 1) >= 0) {
		$data['prevPage'] = $pageId - 1;
	}
	echo $view->render('index/archive.php', $data);
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
