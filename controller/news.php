<?php
use Mailgun\Mailgun;

$app->group('/news', function() use ($app, $view) {

	$app->get('/:id', function($itemId) use ($app, $view) {
		$newsData = $app->di['cache']->get('news:'.$itemId);
        $news = new \Phpdev\Model\News($app->di['db']);
        $news->addViewCount($itemId);

		if ($newsData === null) {
			//$news = new \Phpdev\Model\News($app->di['db']);
			$news->findById($itemId);
			$pending = ($news->date <= time()) ? false : true;
			//$news->addViewCount();

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
			$app->di['cache']->set('news:'.$itemId, $renderedNews);
		} else {
			$renderedNews = $newsData;
		}
        $data = ['item' => $renderedNews];

		echo $view->render('news/view.php', $data);

	})->conditions(array('id' => '[0-9]+'));

	$app->get('/submit', function() use ($app, $view) {
		echo $view->render('news/submit.php');
	});
	$app->post('/submit', function() use ($app, $view) {
		$data = $app->request->post();

        $mg = new Mailgun('key-bea3f09c427ef010a33c2710aebeae98');
        $domain = 'phpdeveloper.org';
        $domain = 'sandbox007d6d6814314253851907a50f146a99.mailgun.org';

        $denyRegex = [
            '/176\.10\.104/', '/188\.143\.232/', '/120\.40\.144\.210/',
            '/27\.153\.156\.165/', '/46\.119\.115/', '/76\.164\.202/',
            '/142\.54\.172/', '/120\.43\.27/'
        ];
        $match = false;
        foreach ($denyRegex as $regex) {
            $find = preg_match($regex, $_SERVER['REMOTE_ADDR']);
            if ($match == false && $find == 1) {
                $match = true;
            }
        }

        if ($match == false){
        $mg->sendMessage($domain, [
            'from' => 'commentMonitor@phpdeveloper.org',
            'to' => 'enygma@phpdeveloper.org',
            'subject' => 'News Submission: '.$data['title'],
            'text' => 'From: '.$data['name']."\n\nStory:\n".$data['story']."\n\nIP address: ".$_SERVER['REMOTE_ADDR']."\n\n"
        ]);
        }

		// Send the email with the content
		/*
        $subject = 'News Submission: '.$data['title'];
		$body = 'From: '.$data['name']."\n\nStory:\n".$data['story']."\n\n";

		mail('enygma@phpdeveloper.org', $subject, $body, "From: commentMonitor@phpdeveloper.org\r\n");
        */
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
