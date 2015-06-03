<?php

namespace Phpdev\Collection;

class Releases extends \Phpdev\Collection\Mysql
{
	public function findLatestByType($type, $limit = 10)
	{
		$start = strtotime('-7 days');
		$end = time();

		$sql = 'select * from releases where rel_type = lower("'.$type.'")'
			.' and date_posted >= '.$start.' and date_posted <= '.$end
			.' order by date_posted desc';

		$results = $this->fetch($sql);
		foreach ($results as $result) {
			$release = new \Phpdev\Model\Release($this->getDb());
			$release->load($result, false);
			$this->add($release);
		}
	}

	public function findByTitle($title)
	{
		$sql = 'select r.* from releases r where rel_title = :title';
		$results = $this->fetch($sql, array('title' => $title));

		foreach ($results as $result) {
			$release = new \Phpdev\Model\Release($this->getDb());
			$release->load($result, false);
			$this->add($release);
		}
	}
}