<?php namespace Ionut\SecurityListener\Receivers;

use Ionut\SecurityListener\Alert;

abstract class Receiver {


	abstract public function __construct($listener);

	abstract public function call(Alert $alert);

	public function allowed()
	{
		return (bool)$this->listener->config->receivers[$this->getShortName()];
	}

	public function getShortName()
	{
		$long  = get_class($this);
		$short = explode('\\', $long);
		$short = $short[count($short) - 1];

		return strtolower($short);
	}

}