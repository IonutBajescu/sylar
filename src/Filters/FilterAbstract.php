<?php namespace Ionut\Sylar\Filters;

abstract class FilterAbstract {

	/**
	 * @param string $input
	 * @return bool
	 */
	abstract public function match($input);

	/**
	 * @return int
	 */
	abstract public function getGravity();

	/**
	 * @return string
	 */
	abstract public function getPattern();

	/**
	 * @return string
	 */
	abstract public function getDesc();

	/**
	 * @return string
	 */
	abstract public function getType();

	public function toArray()
	{
		return [$this->getPattern(), strtolower($this->getType())];
	}
}