<?php namespace Ionut\SecurityListener;

class DynamicObject extends \stdClass {

	public function __call($closure, $args)
	{
		return call_user_func_array($this->{$closure}->bindTo($this), $args);
	}

	public function __toString()
	{
		return call_user_func($this->{"__toString"}->bindTo($this));
	}
}