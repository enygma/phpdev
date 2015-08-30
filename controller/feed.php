<?php
use League\CommonMark\CommonMarkConverter;

$app->group('/feed', function() use ($app, $view) {

	$app->get('/', function() use ($app, $view) {
		$app->response->headers->set('Content-Type', 'text/xml');
		$feedData = $app->di['cache']->get('feed');

		if ($feedData === null) {
			$news = new \Phpdev\Collection\News($app->di['db']);
			$news->findLatest();
			$news = $news->toArray(true);
			$app->di['cache']->set('feed', $news);
		} else {
			$news = $feedData;
		}

        $converter = new CommonMarkConverter();
        foreach ($news as $index => $item) {
            $news[$index]['story'] = (isset($news[$index]['story'])) ? stripslashes($news[$index]['story']) : '';
            $news[$index]['story'] = $converter->convertToHtml($news[$index]['story']);
            //$news[$index]['story'] = strip_tags($news[$index]['story']);
        }

	    echo $view->render('feed/index.php', array(
	    	'news' => $news
	    ));
	});

});
