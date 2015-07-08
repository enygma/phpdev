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
	})->conditions(array('id' => '[0-9]+'));

	$app->get('/submit', function() use ($app, $view) {
		echo $view->render('news/submit.php');
	});
	$app->post('/submit', function() use ($app, $view) {
		$data = $app->request->post();

		// Send the email with the content
		$subject = 'News Submission: '.$data['title'];
		$body = 'From: '.$data['name']."\n\nStory:\n".$data['story']."\n\n";

		mail('enygma@phpdeveloper.org', $subject, $body, "From: commentMonitor@phpdeveloper.org\r\n");
		echo $view->render(
			'news/submit.php',
			array('success' => true)
		);
	});

	$app->get('/add', function() use ($app, $view) {
		echo $view->render('news/add.php');
	});
	$app->post('/add', function() use ($app, $view) {
		echo $view->render('news/add.php');
	});

});