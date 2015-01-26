<?php namespace Ionut\Sylar;

class Receivers extends Container {

	public $receivers = [];
	protected $listener;


	public function __construct(Guardian $listener)
	{
		$this->listener = $listener;
	}

	public function bindReceivers(array $receivers)
	{
		foreach ($receivers as $receiver) {
			$this->bindReceiver($receiver);
		}
	}

	public function bindReceiver($receiver)
	{
		$this->singleton($receiver, function () use ($receiver) {
			return new $receiver($this->listener);
		});

		$this->receivers[] = $receiver;
	}

	public function send($summary)
	{
		// send summary to all available receivers
		foreach ($this->receivers as $receiver) {
			$receiver = $this->make($receiver);
			if ($receiver->allowed()) {
				$receiver->call($summary);
			}
		}
	}
}
