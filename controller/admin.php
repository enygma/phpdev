<?php

use \Psecio\Gatekeeper\Gatekeeper as g;

$app->group('/admin', function() use ($app, $view) {

	function addDates($data) {
		$calInfo = cal_info();

		return array_merge(
			$data,
			array(
				'days' => range(1, date('d', strtotime('last day of this month'))),
				'months' => $calInfo[0]['abbrevmonths'],
				'years' => range(date('Y'), date('Y')-10),
				'hours' => range(0, 23),
				'minutes' => range(1, 59),
				'seconds' => range(1, 59),
				'now' => time()
			)
		);
	}

	function saveNewsItem($data, \Phpdev\Model\News $item)
	{
		$message = 'News item saved successfully!';
		try {
			if ($item->verify() !== true) {
				$success = false;
				$message = 'There was an error saving the news item!';
			} else {
				// Validation is good - save!
				$success = $item->save();
				$message .= ' <a href="/news/'.$item->id.'">Click here</a> to view.';
			}
		} catch (\Exception $e) {
			$success = false;
			$message = $e->getMessage();
		}

		// Delete any previous tags and resave the current ones
		$tag = new \Phpdev\Collection\Tags($item->getDb());
		$tag->findByNewsId($item->id);
		$tag->delete();
		$result = $tag->save($data['tags'], $item->id);

		return array(
			'success' => $success,
			'message' => $message
		);
	}

	$app->get('/', function() use ($app, $view) {

		$user = $app->di['user'];
		if ($user == null || !$user->inGroup(1)) {
			$app->di['session']->getSegment('default')->setFlash('error', 'Not allowed!');
			$app->redirect('/error');
		}

		echo $view->render('admin/index.php');
	});

	$app->get('/news/add', function() use ($app, $view) {
		$user = $app->di['user'];
		if ($user == null || !$user->inGroup(1)) {
			$app->di['session']->getSegment('default')->setFlash('error', 'Not allowed!');
			$app->redirect('/error');
		}

		$item = new \Phpdev\Model\News($app->di['db']);
		$item->load(array(
			'date' => time()
		));

		echo $view->render(
			'admin/news-add.php',
			addDates(array(
				'item' => $item->toArray(),
				'action' => 'add'
			))
		);
	});

	// @todo fix the author for logged in user
	$app->post('/news/add', function() use ($app, $view) {
		$user = $app->di['user'];
		if ($user == null || !$user->inGroup(1)) {
			$app->di['session']->getSegment('default')->setFlash('error', 'Not allowed!');
			$app->redirect('/error');
		}

		$success = true;
		$message = 'News item saved successfully!';
		$data = $app->request->post();

		$viewData = array(
			'action' => 'add'
		);
		$item = new \Phpdev\Model\News($app->di['db']);
		$item->load(array(
			'title' => trim($data['title']),
			'story' => trim($data['story']),
			'author' => $user->username,
			'views' => 0,
			'date' => mktime(
				$data['hour'], $data['minute'], $data['second'],
				$data['month'], $data['day'], $data['year']
			),
			'link' => $data['link'],
			'del_tags' => $data['tags']
		));
		$result = saveNewsItem($data, $item);

		if ($result !== null) {
			$viewData = array_merge($viewData, $result);
		}
		$viewData['item'] = $item->toArray();

		echo $view->render(
			'admin/news-add.php',
			addDates($viewData)
		);
	});

	$app->get('/news/edit/:id', function($newsId) use ($app, $view) {
		$user = $app->di['user'];
		if ($user == null || !$user->inGroup(1)) {
			$app->di['session']->getSegment('default')->setFlash('error', 'Not allowed!');
			$app->redirect('/error');
		}

		$item = new \Phpdev\Model\News($app->di['db']);
		$item->findById($newsId);
		$item = $item->toArray();

		echo $view->render(
			'admin/news-add.php',
			addDates(array(
				'item' => $item,
				'action' => 'edit'
			))
		);
	});
	$app->post('/news/edit/:id', function($newsId) use ($app, $view) {
		$data = $app->request->post();
		$item = new \Phpdev\Model\News($app->di['db']);
		$item->findById($newsId);

		$item->load(array(
			'title' => trim($data['title']),
			'story' => trim($data['story']),
			'date' => mktime(
				$data['hour'], $data['minute'], $data['second'],
				$data['month'], $data['day'], $data['year']
			),
			'link' => $data['link'],
			'del_tags' => $data['tags']
		));

		$viewData = addDates(array(
			'item' => $item->toArray(),
			'action' => 'edit'
		));

		$result = saveNewsItem($data, $item);
		if ($result !== null) {
			$viewData = array_merge($viewData, $result);
		}

		$view->render('admin/news-add.php', $viewData);
	});

	$app->get('/news/delete/:id', function($newsId) use ($app, $view) {
		$item = new \Phpdev\Model\News($app->di['db']);
		$item->findById($newsId);

		$viewData = array(
			'item' => $item->toArray()
		);
		$view->render('admin/news-delete.php', $viewData);
	});
	$app->post('/news/delete/:id', function($newsId) use ($app, $view) {
		$message = 'Item successfully removed!';
		$item = new \Phpdev\Model\News($app->di['db']);
		$item->findById($newsId);

		try {
			$result = $item->delete();
		} catch (\Exception $e) {
			$message = 'There was an error removing the news item.';
			$result = false;
		}
		$viewData = array(
			'message' => $message,
			'success' => $result
		);
		$view->render('admin/news-delete.php', $viewData);
	});


	$app->get('/login', function() use ($app, $view) {
		echo $view->render('admin/login.php');
	});
	$app->post('/login', function() use ($app, $view) {
		$success = true;
		$message = 'Login successful!';
		$data = $app->request->post();

		$credentials = array(
			'username' => $data['username'],
			'password' => $data['password']
		);
		if (g::authenticate($credentials, true) !== true) {
			$success = false;
			$message = 'Error logging in.';
		} else {
			$user = g::findUserByUsername($data['username']);
			if ($user) {
				$segment = $app->di['session']->getSegment('default');
				$segment->set('user', $user->toArray(array('password')));
			}
		}

		echo $view->render('admin/login.php', array(
			'success' => $success,
			'message' => $message
		));
	});

	$app->get('/logout', function() use ($app, $view) {
		$segment = $app->di['session']->clear();
		$view->render('admin/logout.php');
	});

	$app->get('/register', function() use ($app, $view) {
		$view->render('admin/register.php');
	});
	$app->post('/register', function() use ($app, $view) {
		$data = $app->request->post();
		$message = 'User created!';
		$success = true;

		$credentials = array(
			'username' => $data['username'],
			'password' => $data['password'],
			'email' => $data['email'],
			'first_name' => $data['fname'],
			'last_name' => $data['lname']
		);
		if (g::register($credentials) !== true) {
			$success = false;
			$message = 'Error creating user!';
		}

		$view->render('admin/register.php', array(
			'message' => $message,
			'success' => $success
		));
	});

	$app->get('/stats', function() use ($app, $view) {

		$news = new \Phpdev\Collection\News($app->di['db']);
		$news->findLatest(15, 0 , true);

		$active = array();
		$pending = array();

		foreach ($news->toArray(true) as $item) {
			if ($item['date'] <= time()) {
				$active[] = $item;
			} else {
				$pending[] = $item;
			}
		}

		echo $view->render('admin/stats.php', array(
			'active' => $active,
			'pending' => $pending
		));
	});
});