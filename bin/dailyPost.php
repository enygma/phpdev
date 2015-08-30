#!/usr/bin/env php
<?php

require_once __DIR__.'/../vendor/autoload.php';

// Custom autoloader
spl_autoload_register(function($class) {
    $path = __DIR__.'/../lib/'.str_replace('\\', '/', $class).'.php';
    if (is_file($path)) {
        require_once $path;
    }
});

$types = array(
	1 => array(
		'type' => 'pear',
		'title' => 'Community News: Latest PEAR Releases',
		'message' => 'Latest PEAR Releases:'
	),
	2 => array(
		'type' => 'pecl',
		'title' => 'Community News: Latest PECL Releases',
		'message' => 'Latest PECL Releases:'
	),
	3 => array(
		'type' => 'phpquickfix',
		'title' => 'Community News: Recent posts from PHP Quickfix',
		'message' => 'Recent posts from the <a href="http://phpquickfix.me">PHP Quickfix</a> site:'
	),
	4 => array(
		'type' => 'yearago',
		'title' => 'Site News: Blast from the Past - One Year Ago in PHP',
		'message' => "Here's what was popular in the PHP community one year ago today:"
	),
	5 => array(
		'type' => 'popular',
		'title' => 'Site News: Popular Posts for This Week',
		'message' => 'Popular posts from PHPDeveloper.org for the past week:'
	)
	// 6 => 'jobs'
);

$dsn = 'mysql:host=127.0.0.1;dbname=phpdev';
$pdo = new \PDO($dsn, 'phpdev', 'phpdev42');

$type = $types[date('N')];
//$type = $types[1];
$story = '';
$data = array();

switch ($type['type']) {
	case 'pecl':
	case 'pear':
	case 'phpquickfix':
		$releases = new \Phpdev\Collection\Releases($pdo);
		$releases->findLatestByType($type['type']);

		foreach ($releases as $release) {
			$data[] = array(
				'link' => $release->link,
				'title' => $release->title,
				'description' => $release->description
			);
		}
		break;
	case 'yearago':
		$news = new \Phpdev\Collection\News($pdo);
		$news->findYearAgo();

		foreach ($news as $item) {
			$data[] = array(
				'link' => 'http://phpdeveloper.org/news/'.$item->id,
				'title' => $item->title
			);
		}
		break;
	case 'popular':
		$news = new \Phpdev\Collection\News($pdo);
		$news->findPopular();

		foreach ($news as $item) {
			$data[] = array(
				'link' => 'http://phpdeveloper.org/news/'.$item->id,
				'title' => $item->title
			);
		}
		break;
}

// ------ Build the output
if (count($data) == 0) {
	die("Nothing to post for type '".$type['type']."'\n");
}

$story .= (isset($type['message'])) ? $type['message'].'<br/><br/>' : '';
$story .= '<ul>';
foreach ($data as $item) {
	$story .= '<li><a href="'.$item['link'].'">'.$item['title'].'</a>';
	if (isset($item['description'])) {
		$story .= '<br/>'.$item['description'];
	}
	$story .= "\n";
}
$story .= '</ul>';

$news = new \Phpdev\Model\News($pdo);
$news->title = $type['title'].' ('.date('m.d.Y').')';
$news->date = time();
$news->views = 0;
$news->story = $story;
$news->author = 'enygma';

$news->save();
