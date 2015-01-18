<?php namespace Ionut\Sylar\Receivers;

use Ionut\Sylar\Alert;
use Ionut\Sylar\Listener;

class Blocker extends Receiver {

	public function __construct(Listener $listener)
	{
		$this->listener = $listener;
	}

	public function call(Alert $alert)
	{
		$config = $this->getConfig();
		if ($alert->isWorstThan($config['min_gravity'])) {
			$ip = $this->listener->waf->getIp();
			$this->listener->wafStorage->add($ip);

			// retrigger listener
			$this->listener->waf->listen();
		}
	}
}

