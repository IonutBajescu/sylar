<?php namespace Ionut\SecurityListener\Receivers;

class Log extends Receiver {

	public function __construct($listener)
	{
		$this->listener = $listener;
	}

	public function openLogFile()
	{
		$file = $this->listener->config->receivers['log']['to'];
		return fopen($file, 'a+');
	}

	public function getFileHandler()
	{
		static $handler;
		if(is_null($handler)){
			$handler = $this->openLogFile();
		}

		return $handler;
	}

	public function call($info)
	{
		return (bool)fwrite($this->getFileHandler(), $info.PHP_EOL);
	}
}

