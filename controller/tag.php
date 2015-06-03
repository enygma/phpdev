<?php

$app->group('/tag', function() use ($app, $view) {

	$app->get('/:tag(/:page)', function($tag, $page = 1) use ($app, $view) {
		$news = new \Phpdev\Collection\News($app->di['db']);
		$news->findByTag($tag, $page);

		$newsRendered = '';
		$itemView = new \Phpdev\View\NewsItemView();
		foreach ($news as $item) {
			$newsRendered .= $itemView->render('news/_item.php', array(
				'news' => $item,
				'tags' => $item->tags->toArray(true)
			));
		}

	    echo $view->render('index/index.php', array(
	    	'news' => $newsRendered
	    ));
	});
});