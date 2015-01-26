<?php namespace Ionut\Sylar\Filters\TheDefault;

use Ionut\Sylar\Filters\BaseCollection;

/**
 * Default filters collection for SecurityListener.
 *
 * @package Ionut\Sylar\Filters\Guardian
 */
class Collection extends BaseCollection {

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
			$filter = new Filter($filter->pattern, $filter->gravity, $filter->desc, $filter->type);
			$this->push($filter);
		}
	}

	/**
	 * @return string
	 */
	protected function getFilePath()
	{
		return __DIR__ . '/filters.json';
	}
}
