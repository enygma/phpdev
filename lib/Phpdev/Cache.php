<?php

namespace Phpdev;

class Cache
{
	/**
	 * File path directory
	 * @var string
	 */
	private $path = '/tmp';

	/**
	 * Set a timeout in seconds
	 * @var integer
	 */
	private $timeout = 3600;

	public function __construct($timeout = null)
	{
		if ($timeout !== null && is_int($timeout)) {
			$this->timeout = $timeout;
		}
	}

	/**
	 * Built the path to the cache file
	 *
	 * @param string $key Key name
	 * @return string File path
	 */
	private function buildFilename($key)
	{
		return $this->path.'/'.md5($key).'.cache';
	}

	/**
	 * Get he value if the cache file exists
	 *
	 * @param string $key Key to locate
	 * @return null|mixed Either data if found or null
	 */
	public function get($key)
	{
		$file = $this->buildFilename($key);
		if (is_file($file)) {
			// Check the file time versus the timeout
			$mtime = filemtime($file);
			if ($mtime <= time()-$this->timeout) {
				$this->delete($key);
				return null;
			}

			return unserialize(file_get_contents($file));
		}
	}

	/**
	 * Set a value to the cache
	 *
	 * @param string $key Key name
	 * @param mixed $value Data to save
	 */
	public function set($key, $value)
	{
		if (is_object($value)) {
			$value = $value->serialize();
		}

		$file = $this->buildFilename($key);
		file_put_contents($file, serialize($value));
	}

	/**
	 * Delete a value from the cache
	 *
	 * @param string $key Key name to remove
	 * @return null|boolean Boolean result of unlink or null if not found
	 */
	public function delete($key)
	{
		$file = $this->buildFilename($key);
		if (is_file($file)) {
			return unlink($file);
		}
	}
}
