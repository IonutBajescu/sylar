<?php namespace Ionut\SecurityListener\Receivers;

abstract class Receiver {


	abstract public function __construct($listener);

	abstract public function call($summary);

	public function allowed()
	{
		return (bool)$this->listener->config->receivers[$this->getShortName()];
	}

	public function getShortName()
	{
		$long = get_class($this);
		$short = explode('\\', $long);
		$short = $short[count($short)-1];
		return strtolower($short);
	}

}