<?php namespace Ionut\SecurityListener\Receivers;

use Ionut\SecurityListener\Alert;
use Ionut\SecurityListener\Listener;

abstract class Receiver {

	/**
	 * @var Listener
	 */
	public $listener;

	abstract public function __construct(Listener $listener);

	abstract public function call(Alert $alert);

	public function allowed()
	{
		return (bool)$this->getConfig();
	}

	public function getConfig()
	{
		return $this->listener->config->receivers[$this->getShortName()];
	}

	public function getShortName()
	{
		$long  = get_class($this);
		$short = explode('\\', $long);
		$short = $short[count($short) - 1];

		return strtolower($short);
	}

}