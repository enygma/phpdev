<?php

namespace Phpdev\View;

class TemplateView extends \Slim\Views\Twig
{
	public function render($template, $data = null)
	{
		$data['archive'] = array(
			array('title' => 'test1'),
			array('title' => 'test2')
		);

		// Grab the tag could info
		$tags = new \Phpdev\Collection\Tags($this->di['db']);
		$tags->findPopular();

		$view = new \Slim\Views\Twig();
		$view->setTemplatesDirectory('../templates');
		$data['tagcloud'] = $view->render('index/tagcloud.php', array(
	    	'tags' => $tags->toArray(true)
	    ));

		// $data['tags'] = $tags->toArray(true);
		// $data['tagcloud'] = 'test';

		$news = new \Phpdev\Collection\News($this->di['db']);
		$news->findLatest(10, 10);
		$data['archive'] = $news->toArray(true);

		// see if we have a logged in user
		$user = $this->di['user'];
		if ($user !== null) {
			$data['username'] = $user->username;
			$data['userId'] = $user->id;
		}

		echo parent::render($template, $data);
	}
}