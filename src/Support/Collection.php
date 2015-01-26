<?php namespace Ionut\Sylar\Support;

class Collection extends \Illuminate\Support\Collection {

	public function __get($k)
	{
		return $this[$k];
	}

	public function __set($k, $v)
	{
		$this[$k] = $v;
	}
} 