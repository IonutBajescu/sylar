<?php namespace Ionut\SecurityListener\Receivers;

use Ionut\SecurityListener\Alert;
use Ionut\SecurityListener\Listener;

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

