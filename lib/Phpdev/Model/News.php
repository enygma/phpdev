<?php

namespace Phpdev\Model;

class News extends \Phpdev\Model\Mysql
{
	protected $tableName = 'news';

	protected $properties = array(
		'id' => array(
			'name' => 'ID',
			'description' => 'ID',
			'column' => 'ID'
		),
		'title' => array(
			'name' => 'Title',
			'description' => 'Title',
			'column' => 'title',
			'required' => true
		),
		'story' => array(
			'name' => 'Story',
			'description' => 'Story',
			'column' => 'story',
			'required' => true
		),
		'date' => array(
			'name' => 'Create Date',
			'description' => 'Create Date',
			'column' => 'date',
			'required' => true
		),
		'author' => array(
			'name' => 'Author',
			'description' => 'Author',
			'column' => 'author',
			'required' => true
		),
		'views' => array(
			'name' => 'Views',
			'description' => 'Views',
			'column' => 'views'
		),
		'link' => array(
			'name' => 'Link',
			'description' => 'Link',
			'column' => 'link',
			'required' => true
		),
		'delTags' => array(
			'name' => 'Del tags',
			'description' => 'Del tags',
			'column' => 'del_tags',
			'required' => true
		),
		'tags' => array(
			'name' => 'News Tags',
			'description' => 'News Tags',
			'type' => 'relation',
			'relation' => array(
				'model' => '\\Phpdev\\Collection\\Tags',
                'method' => 'findByNewsId',
                'local' => 'id'
			)
		)
	);

	public function validateTitle($value)
	{
		return (!empty($value));
	}

	public function validateStory($value)
	{
		return (!empty($value));
	}

	public function validateLink($value)
	{
		return ($value === filter_var($value, FILTER_VALIDATE_URL));
	}

	public function preCreate(array $data)
	{
		// Ensure we don't have something with this title already
		$news = new \Phpdev\Collection\News($this->getDb());
		$news->findByTitle($data['title']);

		if (count($news) !== 0) {
			throw new \Exception('News item already found similar to this one! Not saving.');
		}
		return $data;
	}

	/**
	 * Update the "views" count for the news item
	 *
	 * @return boolean Success/fail of query execute
	 */
	public function addViewCount($itemId = null)
    {
        $id = ($itemId !== null) ? $itemId : $this->id;
        $sql = 'update news set views = views + 1 where id = :id';
        return $this->execute($sql, array('id' => $id));
    }
}
