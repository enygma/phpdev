<?php

$app->group('/news', function() use ($app, $view) {

	$app->get('/:id', function($itemId) use ($app, $view) {
		$news = new \Phpdev\Model\News($app->di['db']);
		$news->findById($itemId);
		$pending = ($news->date <= time()) ? false : true;
		$news->addViewCount();

		$data = array(
			'news' => $news,
			'tags' => $news->tags->toArray(true),
			'pending' => $pending
		);
		$user = $app->di['user'];
		if ($user !== null && $user->inGroup('admin')) {
			$data['admin'] = true;
		}

		$itemView = new \Phpdev\View\NewsItemView();
		$renderedNews = $itemView->render('news/_item.php', $data);

		echo $view->render('news/view.php', array(
			'item' => $renderedNews
		));
	});

	$app->get('/add', function() use ($app, $view) {
		echo $view->render('news/add.php');
	});
	$app->post('/add', function() use ($app, $view) {
		echo $view->render('news/add.php');
	});

});