<?php namespace Ionut\Sylar\Filters\Listener;

use Ionut\Sylar\Filters\CollectionInterface;

/**
 * Default filters collection for SecurityListener.
 *
 * @package Ionut\Sylar\Filters\Listener
 */
class Collection implements CollectionInterface {

	protected $filters;

	public function __construct()
	{
		$this->importFiltersFromJson();
	}


	/**
	 * Import all filters in class from json data.
	 */
	protected function importFiltersFromJson()
	{
		$data = json_decode(file_get_contents($this->getFilePath()));
		foreach ($data->filters as $filter) {
			$this->filters[] = new Filter($filter->pattern, $filter->gravity, $filter->desc, $filter->type);
		}
	}

	/**
	 * @return mixed
	 */
	public function all()
	{
		return $this->filters;
	}

	/**
	 * @return string
	 */
	protected function getFilePath()
	{
		return __DIR__ . '/filters.json';
	}
}
