<?php

namespace Phpdev\Model;

class Tag extends \Phpdev\Model\Mysql
{
	protected $tableName = 'news_tags';

	protected $properties = array(
		'id' => array(
			'name' => 'ID',
			'description' => 'ID',
			'column' => 'ID'
		),
		'tag' => array(
			'name' => 'Tag',
			'description' => 'Tag',
			'column' => 'tag',
			'required' => true
		),
		'newsId' => array(
			'name' => 'News ID',
			'description' => 'News ID',
			'column' => 'news_id',
			'required' => true
		)
	);
}