<?php

namespace Phpdev\View;

use League\CommonMark\CommonMarkConverter;

class NewsItemView extends \Slim\Views\Twig
{
	public function render($template, $data = null)
	{
		$this->setTemplatesDirectory('../templates');

		$news = $data['news']->toArray();
		if (isset($news['author']) && $news['author'] === 'enygma') {
			$news['author'] = 'Chris Cornutt';
		}
		$news['date'] = (isset($news['date'])) ? date('M d, Y @ H:i:s', $news['date']) : '';
		$news['title'] = (isset($news['title'])) ? stripslashes($news['title']) : '';

		$converter = new CommonMarkConverter();
		$news['story'] = (isset($news['story'])) ? stripslashes($news['story']) : '';
		$news['story'] = $converter->convertToHtml($news['story']);

		// Find the first colon and add a <br>
		$first = strpos($news['title'], ':');
		if ($first !== false) {
			$news['title'] = substr($news['title'], 0, $first+1).'<br/>'
				.substr($news['title'], $first+1);
		}

		$data['news'] = array($news);

		return parent::render($template, $data);
	}
}