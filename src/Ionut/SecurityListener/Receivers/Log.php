<?php namespace Ionut\SecurityListener\Receivers;

use Ionut\SecurityListener\Alert;
use Ionut\SecurityListener\Listener;

class Log extends Receiver {

	public function __construct(Listener $listener)
	{
		$this->listener = $listener;
	}

	public function call(Alert $alert)
	{
		return (bool)fwrite($this->getFileHandler(), $alert->getInfo() . PHP_EOL);
	}

	public function getFileHandler()
	{
		static $handler;
		if (is_null($handler)) {
			$handler = $this->openLogFile();
		}

		return $handler;
	}

	public function openLogFile()
	{
		$file = $this->listener->config->receivers['log']['to'];

		return fopen($file, 'a+');
	}
}

