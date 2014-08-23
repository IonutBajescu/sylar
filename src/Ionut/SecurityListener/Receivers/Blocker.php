<?php namespace Ionut\SecurityListener\Receivers;

use Ionut\SecurityListener\Alert;

class Blocker extends Receiver {

	public function __construct($listener)
	{
		$this->listener = $listener;
	}

	public function call(Alert $alert)
	{

	}
}

