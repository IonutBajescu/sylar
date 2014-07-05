<?php namespace Ionut\SecurityListener\Receivers;

class Mail extends Receiver {

	public function __construct($listener)
	{
		$this->listener = $listener;
	}

	public function call($info)
	{

	}
}

