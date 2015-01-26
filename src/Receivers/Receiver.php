<?php namespace Ionut\Sylar\Receivers;

use Ionut\Sylar\Alert;
use Ionut\Sylar\Guardian;

abstract class Receiver {

	/**
	 * @var Guardian
	 */
	public $listener;

	abstract public function __construct(Guardian $listener);

	abstract public function call(Alert $alert);

	public function allowed()
	{
		return (bool)$this->getConfig();
	}

	public function getConfig()
	{
		return $this->listener->config['receivers'][$this->getShortName()];
	}

	public function getShortName()
	{
		$long  = get_class($this);
		$short = explode('\\', $long);
		$short = $short[count($short) - 1];

		return strtolower($short);
	}

}