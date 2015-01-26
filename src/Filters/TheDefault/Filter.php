<?php namespace Ionut\Sylar\Filters\TheDefault;

class Filter extends \Ionut\Sylar\Filters\FilterAbstract {

	/**
	 * @var int
	 */
	private $gravity;
	/**
	 * @var string
	 */
	private $pattern;
	/**
	 * @var string
	 */
	private $desc;
	/**
	 * @var string
	 */
	private $type;

	public function __construct($pattern, $gravity, $desc, $type)
	{

		$this->gravity = $gravity;
		$this->pattern = $pattern;
		$this->desc    = $desc;
		$this->type    = $type;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Check if Filter match the given input.
	 *
	 * @param  $input
	 * @return bool
	 */
	public function match($input)
	{
		return (bool)preg_match('#' . $this->pattern . '#i', $input);
	}

	/**
	 * @return int
	 */
	public function getGravity()
	{
		return $this->gravity;
	}

	/**
	 * @return string
	 */
	public function getPattern()
	{
		return $this->pattern;
	}

	/**
	 * @return string
	 */
	public function getDesc()
	{
		return $this->desc;
	}
}
