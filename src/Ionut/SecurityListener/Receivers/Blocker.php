<?php namespace Ionut\SecurityListener\Receivers;

class Blocker extends Receiver {

	public function __construct($listener)
	{
		$this->listener = $listener;
	}

	public function call($info)
	{

	}
}

