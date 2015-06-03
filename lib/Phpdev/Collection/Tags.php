<?php

namespace Phpdev\Collection;

class Tags extends \Phpdev\Collection\Mysql
{
	public function findByNewsId($newsId)
	{
		$sql = 'select * from news_tags where news_id = :newsId';

		$results = $this->fetch($sql, array('newsId' => $newsId));
		foreach ($results as $result) {
			$tag = new \Phpdev\Model\Tag($this->getDb());
			$tag->load($result, false);
			$this->add($tag);
		}
	}

	public function save($tags, $newsId)
	{
		if (!is_array($tags)) {
			$tags = explode(' ', $tags);
		}

		foreach ($tags as $tag) {
			$tagInstance = new \Phpdev\Model\Tag($this->getDb());
			$tagInstance->load(array(
				'tag' => $tag,
				'news_id' => $newsId
			));
			$result = $tagInstance->save();
		}
	}

	public function delete()
	{
		foreach ($this->toArray() as $tag) {
			$tag->delete();
		}
	}

	public function findPopular($start = null, $end = null)
	{
		$sql = 'select count(nt.id) cid, nt.tag from news_tags nt, news n'
			.' where tag is not null and tag != ""'
			.' and nt.news_id = n.id'
			.' and n.date >= :start and n.date <= :end'
			.' group by tag order by cid desc limit 10';

		$start = ($start === null) ? strtotime('-3 months') : $start;
		$end = ($end === null) ? time() : $end;

		$data = array(
			'start' => $start,
			'end' => time()
		);
		$results = $this->fetch($sql, $data);

		foreach ($results as $result) {
			$tag = new \Phpdev\Model\Tag($this->getDb());
			$tag->load($result, false);
			$this->add($tag);
		}
	}
}