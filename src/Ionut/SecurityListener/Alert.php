<?php namespace Ionut\SecurityListener;

class Alert {

	public $gravityRange = [
		'low',
		'medium',
		'high'
	];

	private $info;
	private $type;
	private $gravity;

	function __construct($info, $type, $gravity)
	{
		$this->info = $info;
		$this->type = $type;
		$this->gravity = $gravity;
	}

	/**
	 * @param string $gravity
	 *
	 * @return bool
	 */
	public function isWorstThan($gravity)
	{
		return $this->getGravityIndex() >= array_search($gravity, $this->gravityRange);
	}

	public function getGravityIndex()
	{
		return array_search($this->gravity, $this->gravityRange);
	}
	
	/**
	 * @return mixed
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param mixed $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	public function __toString()
	{
		return $this->getInfo();
	}

	/**
	 * @return string
	 */
	public function getInfo()
	{
		return $this->info;
	}

	/**
	 * @param string $info
	 */
	public function setInfo($info)
	{
		$this->info = $info;
	}
} 