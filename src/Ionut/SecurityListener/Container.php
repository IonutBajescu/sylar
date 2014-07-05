<?php namespace Ionut\SecurityListener;


use \Illuminate\Container\Container as BaseContainer;

class Container extends BaseContainer {

	public function __set($k, $v)
	{
		$this[$k] = $v;
	}

	public function __get($k)
	{
		return $this[$k];
	}
}
