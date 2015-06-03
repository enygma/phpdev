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

$dsn = 'mysql:host=127.0.0.1;dbname=phpdev';
$pdo = new \PDO($dsn, 'phpdev', 'phpdev42');

$feeds = array(
	'pear' => 'http://pear.php.net/feeds/latest.rss',
	'pecl' => 'http://pecl.php.net/feeds/latest.rss',
	'composer-releases' => 'http://packagist.org/feeds/releases.rss',
	'phpquickfix' => 'http://phpquickfix.me/feed'
	// 'classes'       =>'http://www.phpclasses.org/browse/latest/latest.xml',
	// 'phpdev_blog'   =>'http://blog.phpdeveloper.org/?feed=rss2',
	// 'secfocus'      =>'http://phpsec.org/projects/vulnerabilities/securityfocus.xml',
	// 'devnetwork'    =>'http://forums.devnetwork.net/rss.php',
	// 'cakephp'       =>'http://bakery.cakephp.org/articles/rss',
	// 'phpw'          =>'http://www.phpwomen.org/forum/rdf.php?mode=m&l=1&n=10&basic=1',
);
foreach ($feeds as $type => $feedUrl) {
	echo 'Grabbing feed: '.$type."\n";

	$data = str_replace('&', '&amp;', file_get_contents($feedUrl));
	$data = simplexml_load_string(trim($data));

	if (in_array($type, array('phpquickfix', 'composer-releases'))) {
		$items = $data->channel->item;
	} else {
		$items = $data->item;
	}

	foreach ($items as $item) {
		if (in_array($type, array('composer-releases', 'phpquickfix'))) {
			$children = $item->children('http://purl.org/dc/elements/1.1/');
			$date = strtotime($children->date);
		} else {
			$date = strtotime($item->pubDate);
		}

		$release = new \Phpdev\Model\Release($pdo);
		$release->title = (string)$item->title;
		$release->link = (string)$item->link;
		$release->datePosted = ($date === false) ? time() : $date;
		$release->description = (string)$item->description;
		$release->type = $type;

		try {
			$release->save();
			echo $release->title." saved.\n";
		} catch (\Exception $e) {
			// don't do anything with this
		}

	}
}
