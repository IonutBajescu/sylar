<?php namespace Ionut\Sylar;

use Illuminate\Events\Dispatcher;

/**
 * @property \Illuminate\Events\Dispatcher $events
 */
class Environment extends Container {
	public $name = 'The Sylar v1.0';


	public function __construct()
	{
		$this['events']  = new Dispatcher($this);
		$this->singleton('request', function(){
			return new Request();
		});
	}
} 