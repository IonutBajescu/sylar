<?php namespace Ionut\SecurityListener;

class Alert {


	private $info;
	private $type;

	function __construct($info, $type)
	{
		$this->info = $info;
		$this->type = $type;
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