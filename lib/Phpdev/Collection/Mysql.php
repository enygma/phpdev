<?php

namespace Phpdev\Collection;

class Mysql extends \Modler\Collection
{
	private $db;

	public function __construct($db)
	{
		$this->setDb($db);
	}

	public function setDb($db)
	{
		$this->db = $db;
	}

	public function getDb()
	{
		return (get_class($this->db) == 'PDO') ? $this->db : $this->db['db'];
	}

    /**
     * Perform actions to allow for serilization of instance
     */
    public function serialize()
    {
        $this->db = null;
    }

	/**
     * Fetch the data matching the results of the SQL operation
     *
     * @param string $sql SQL statement
     * @param array $data Data to use in fetch operation
     * @param boolean $single Only fetch a single record
     * @return array Fetched data
     */
    public function fetch($sql, array $data = array(), $single = false)
    {
        $sth = $this->getDb()->prepare($sql);
        $result = $sth->execute($data);

        if ($result === false) {
            $error = $sth->errorInfo();
            $this->lastError = 'DB ERROR: ['.$sth->errorCode().'] '.$error[2];
            error_log($this->lastError);
            return false;
        }

        $results = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return ($single === true) ? array_shift($results) : $results;
    }
}