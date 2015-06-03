<?php

namespace Phpdev\View;

class NewsItemView extends \Slim\Views\Twig
{
	public function render($template, $data = null)
	{
		$this->setTemplatesDirectory('../templates');

		$news = $data['news']->toArray();
		if ($news['author'] === 'enygma') {
			$news['author'] = 'Chris Cornutt';
		}
		$news['date'] = date('M d, Y @ H:i:s', $news['date']);
		$news['title'] = stripslashes($news['title']);
		$news['story'] = stripslashes($news['story']);

		// Find the first colon and add a <br>
		$first = strpos($news['title'], ':');
		$news['title'] = substr($news['title'], 0, $first+1).'<br/>'
			.substr($news['title'], $first+1);

		$data['news'] = array($news);

		return parent::render($template, $data);
	}
}