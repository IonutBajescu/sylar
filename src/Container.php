<?php namespace Ionut\Sylar;


use Illuminate\Container\Container as BaseContainer;

class Container extends BaseContainer {

	public function __get($k)
	{
		return $this[$k];
	}

	public function __set($k, $v)
	{
		$this[$k] = $v;
	}
}
