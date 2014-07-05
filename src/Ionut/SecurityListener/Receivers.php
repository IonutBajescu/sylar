<?php namespace Ionut\SecurityListener;

class Receivers extends Container{

	public $receivers = [];


	public function __construct(Listener $listener)
	{
		$this->listener = $listener;
	}

	public function bindReceivers(array $receivers)
	{
		foreach($receivers as $receiver){
			$this->bindReceiver($receiver);
		}
	}

	public function bindReceiver($receiver)
	{
		$this->singleton($receiver, function() use($receiver){
			return new $receiver($this->listener);
		});

		$this->receivers[] = $receiver;
	}

	public function send($summary)
	{
		// send summary to all available receivers
		foreach($this->receivers as $receiver){
			$receiver = $this->make($receiver);
			if($receiver->allowed()){
				$receiver->call($summary);
			}
		}
	}
}
