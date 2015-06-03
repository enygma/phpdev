<?php

namespace Phpdev\Model;

class Release extends \Phpdev\Model\Mysql
{
	protected $tableName = 'releases';

	protected $properties = array(
		'id' => array(
			'name' => 'ID',
			'description' => 'ID',
			'column' => 'ID'
		),
		'type' => array(
			'name' => 'Release Type',
			'column' => 'rel_type'
		),
		'title' => array(
			'name' => 'Title',
			'column' => 'rel_title'
		),
		'link' => array(
			'name' => 'Link',
			'column' => 'rel_link'
		),
		'description' => array(
			'name' => 'Description',
			'column' => 'rel_desc'
		),
		'datePosted' => array(
			'name' => 'Date Posted',
			'column' => 'date_posted'
		),
		'contact' => array(
			'name' => 'Contact',
			'column' => 'rel_contact'
		),
		'approval' => array(
			'name' => 'Approval status',
			'column' => 'approval'
		),
		'isPosted' => array(
			'name' => 'Is posted',
			'column' => 'is_posted'
		)
	);

	public function preCreate(array $data)
	{
		// Ensure we don't have something with this title already
		$news = new \Phpdev\Collection\Releases($this->getDb());
		$news->findByTitle($data['title']);

		if (count($news) !== 0) {
			throw new \Exception('Release item already found similar to this one! Not saving.');
		}
		return $data;
	}
}