<?php

namespace Phpdev\Collection;

class News extends \Phpdev\Collection\Mysql
{
	public function findLatest($limit = 10, $start = 0, $pending = false)
	{
		$sql = 'select * from news';
		if ($pending === false) {
			$sql .= ' where FROM_UNIXTIME(date) <= now()';
		}
		$sql .=' order by date desc limit '.$start.','.$limit;

		$results = $this->fetch($sql);
		foreach ($results as $result) {
			$news = new \Phpdev\Model\News($this->getDb());
			$news->load($result, false);
			$this->add($news);
		}
	}

	public function findDateRange($start = null, $end = null)
	{
		$start = ($start === null) ? strtotime('-7 days') : $start;
		$end = ($end === null) ? time() : $end;
		$sql = 'select * from news where date >= :start and date <= :end order by date desc';
		$results = $this->fetch($sql, array(
			'start' => $start,
			'end' => $end
		));

		foreach ($results as $result) {
			$news = new \Phpdev\Model\News($this->getDb());
			$news->load($result, false);
			$this->add($news);
		}
	}

	public function findByTag($tag, $page = 1)
	{
		$limit = ($page == 1) ? 10 : (($page*10)-10).', 10';
		$sql = 'select n.* from news n, news_tags nt'
			.' where n.id = nt.news_id and lower(tag) = :tag'
			.' order by date desc limit '.$limit;

		$results = $this->fetch($sql, array(
			'tag' => $tag
		));

		foreach ($results as $result) {
			$news = new \Phpdev\Model\News($this->getDb());
			$news->load($result, false);
			$this->add($news);
		}
	}

	public function findByTitle($title)
	{
		$sql = 'select n.* from news n where title = :title';
		$results = $this->fetch($sql, array('title' => $title));

		foreach ($results as $result) {
			$news = new \Phpdev\Model\News($this->getDb());
			$news->load($result, false);
			$this->add($news);
		}
	}

	public function findPopular($start = null, $end = null)
	{
		// get the items for this week and order them by most views
		if ($start === null) {
			$start = strtotime('Sunday last week');
		}
		if ($end === null) {
			$end = mktime(23, 59, 59, date('m'), date('d'), date('y'));
		}

		$sql = 'select ID, title, views from news where date >= '.$start
			.' and date <= '.$end.' and'
			.' title not like "Community News: %"'
			.' and title not like "Site News: %"'
			.' order by views desc';

		$results = $this->fetch($sql);
		foreach ($results as $result) {
			$news = new \Phpdev\Model\News($this->getDb());
			$news->load($result, false);
			$this->add($news);
		}
	}

	public function findYearAgo()
	{
		$oneYearAgo = strtotime('-1 year');
		$start = strtotime('previous Sunday', $oneYearAgo);
		$end = $start+(86400*7);

		$sql = 'select ID, title, views from news where date >= '.$start
			.' and date <= '.$end.' and'
			.' title not like "Community News: %"'
			.' and title not like "Site News: %"'
			.' order by views desc';

		$results = $this->fetch($sql);
		foreach ($results as $result) {
			$news = new \Phpdev\Model\News($this->getDb());
			$news->load($result, false);
			$this->add($news);
		}
	}
}
